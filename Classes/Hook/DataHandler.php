<?php
/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with TYPO3 source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Causal\DirectMailUserfunc\Hook;

use Causal\DirectMailUserfunc\Utility\ItemsProcFunc;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This class hooks into \TYPO3\CMS\Core\DataHandling\DataHandler to process the virtual fields.
 *
 * @category    Hook
 * @package     direct_mail_userfunc
 * @author      Xavier Perseguers <xavier@causal.ch>
 * @copyright   2013-2018 Causal Sàrl
 * @license     https://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class DataHandler
{

    /**
     * Stores virtual field values into column tx_directmailuserfunc_params.
     * Hook in \TYPO3\CMS\Core\DataHandling\DataHandler
     *
     * @param array $incomingFieldArray
     * @param string $table
     * @param int|string $id
     * @param \TYPO3\CMS\Core\DataHandling\DataHandler $pObj
     * @return void
     */
    public function processDatamap_preProcessFieldArray(array &$incomingFieldArray, $table, $id, \TYPO3\CMS\Core\DataHandling\DataHandler $pObj)
    {
        if ($table !== 'sys_dmail_group') {
            return;
        }

        if (strpos($id, 'NEW') !== false) {
            $row = [];
        } else {
            $row = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord($table, $id);
        }
        $currentValues = ItemsProcFunc::decodeUserParameters($row);

        if (isset($incomingFieldArray['tx_directmailuserfunc_itemsprocfunc'])) {
            $itemsProcFunc = $incomingFieldArray['tx_directmailuserfunc_itemsprocfunc'];
        } else {
            $itemsProcFunc = $row['tx_directmailuserfunc_itemsprocfunc'];
        }

        if (ItemsProcFunc::hasWizardFields($itemsProcFunc)) {
            $wizardFields = ItemsProcFunc::callWizardFields($itemsProcFunc, $pObj);
            $this->reconfigureTCA($wizardFields, $row);
        }

        $virtualValues = [];
        foreach ($incomingFieldArray as $field => $value) {
            if (GeneralUtility::isFirstPartOfStr($field, 'tx_directmailuserfunc_virtual_')) {
                $virtualField = substr($field, strlen('tx_directmailuserfunc_virtual_'));

                // Evaluate field
                $curValue = isset($currentValues[$virtualField]) ? $currentValues[$virtualField] : '';
                $res = $this->checkValue($table, $field, $value, $curValue, $id, $status, $row['pid'], $pObj);
                if (isset($res['value'])) {
                    $virtualValues[$virtualField] = $res['value'];
                }

                unset($incomingFieldArray[$field]);
            }
        }

        if (!empty($virtualValues)) {
            $newValues = array_merge($currentValues, $virtualValues);
            ItemsProcFunc::encodeUserParameters($incomingFieldArray, $newValues);
        }
    }

    /**
     * @param string $table Table name
     * @param string $field Field name
     * @param string $value Value to be evaluated. Notice, this is the INPUT value from the form
     * @param string $curValue The original value (from existing record)
     * @param string $id The record-uid, mainly - but not exclusively - used for logging
     * @param string $status 'update' or 'new' flag
     * @param int $realPid The real PID value of the record. For updates, this is just the pid of the record.
     * @param \TYPO3\CMS\Core\DataHandling\DataHandler $pObj
     * @return array Returns the evaluated $value as key "value" in this array. Can be checked with isset($res['value']) ...
     * @see \TYPO3\CMS\Core\DataHandling\DataHandler::checkValue()
     */
    protected function checkValue($table, $field, $value, $curValue, $id, $status, $realPid, \TYPO3\CMS\Core\DataHandling\DataHandler $pObj)
    {
        // Result array
        $res = [];

        // For our use $tscPID is always the real PID
        $tscPID = $realPid;
        // Getting config for the field
        $tcaFieldConf = $GLOBALS['TCA'][$table]['columns'][$field]['config'];

        // Perform processing:
        $res = $pObj->checkValue_SW($res, $value, $tcaFieldConf, $table, $id, $curValue, $status, $realPid, $recFID, $field, [], $tscPID);
        return $res;
    }

    /**
     * Reconfigures the TCA with custom fields.
     *
     * @param array|null $fields
     * @param array $row
     * @return void
     */
    protected function reconfigureTCA(array $fields = null, array &$row)
    {
        if ($fields === null) {
            // The user class is used for both TCA and non TCA-based additional parameters
            // and the standard text area should be shown
            // see https://forge.typo3.org/issues/53287
            return;
        }

        // Remove standard textarea
        $GLOBALS['TCA']['sys_dmail_group']['columns']['tx_directmailuserfunc_params']['config']['type'] = 'passthrough';

        if (count($fields) === 0) {
            // The user class does not need any additional parameters
            return;
        }

        $currentValues = ItemsProcFunc::decodeUserParameters($row);

        if (!isset($fields['type'])) {
            // Without a definition for type "5", custom fields are not shown
            // so we automatically create a basic configuration to show them
            $fields['type']['5'] = [
                'showitem' => implode(', ', array_keys($fields['columns']))
            ];
        }

        // Prefix each additional field
        $prefixedFields = [
            'columns' => [],
            'types' => $fields['type'],
            'palettes' => isset($fields['palettes']) ? $fields['palettes'] : [],
            'ctrl' => isset($fields['ctrl']) ? $fields['ctrl'] : [],
        ];
        foreach ($fields['columns'] as $field => $fieldInfo) {
            $virtualField = 'tx_directmailuserfunc_virtual_' . $field;
            $prefixedFields['columns'][$virtualField] = $fieldInfo;

            if (isset($currentValues[$field])) {
                // Populate virtual field's value
                $row[$virtualField] = $currentValues[$field];
            }

            foreach ($prefixedFields['types'] as &$typeInfo) {
                $typeInfo['showitem'] = preg_replace(
                    '/(^|[, ])' . preg_quote($field) . '([,; ]|$)/',
                    '$1' . $virtualField . '$2',
                    $typeInfo['showitem']
                );
            }

            foreach ($prefixedFields['palettes'] as &$paletteInfo) {
                $paletteInfo['showitem'] = preg_replace(
                    '/(^|[, ])' . preg_quote($field) . '([,; ]|$)/',
                    '$1' . $virtualField . '$2',
                    $paletteInfo['showitem']
                );
            }

            if (!empty($prefixedFields['ctrl']['requestUpdate'])) {
                $prefixedFields['ctrl']['requestUpdate'] = preg_replace(
                    '/(^|[, ])' . preg_quote($field) . '([,; ]|$)/',
                    '$1' . $virtualField . '$2',
                    $prefixedFields['ctrl']['requestUpdate']
                );
            }
        }

        // Reconfigure TCA with virtual fields
        foreach ($prefixedFields['columns'] as $field => $fieldInfo) {
            $GLOBALS['TCA']['sys_dmail_group']['columns'][$field] = $fieldInfo;
        }

        foreach ($prefixedFields['types'] as $type => $typeInfo) {
            if (substr($GLOBALS['TCA']['sys_dmail_group']['types'][$type]['showitem'], -strlen($typeInfo['showitem'])) !== $typeInfo['showitem']) {
                $GLOBALS['TCA']['sys_dmail_group']['types'][$type]['showitem'] .= ',' . $typeInfo['showitem'];
            }
        }

        // sys_dmail_group has no initial palettes
        $GLOBALS['TCA']['sys_dmail_group']['palettes'] = $prefixedFields['palettes'];

        if (!empty($prefixedFields['ctrl']['requestUpdate'])) {
            $GLOBALS['TCA']['sys_dmail_group']['ctrl']['requestUpdate'] .= ',' . $prefixedFields['ctrl']['requestUpdate'];
        }
    }

}
