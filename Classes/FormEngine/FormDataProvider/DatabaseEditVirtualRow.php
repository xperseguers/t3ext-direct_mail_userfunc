<?php
/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Causal\DirectMailUserfunc\FormEngine\FormDataProvider;

use TYPO3\CMS\Backend\Form\FormDataProviderInterface;
use Causal\DirectMailUserfunc\Utility\ItemsProcFunc;

class DatabaseEditVirtualRow implements FormDataProviderInterface
{

    /**
     * Remove fields depending on switchable controller action in tt_content
     * Restrict category selection based on configuration in tt_content
     *
     * @param array $result
     * @return array
     */
    public function addData(array $result)
    {
        if ($result['tableName'] === 'sys_dmail_group') {
            $wizardFields = null;
            $itemsProcFunc = $result['databaseRow']['tx_directmailuserfunc_itemsprocfunc'];

            if (ItemsProcFunc::hasWizardFields($itemsProcFunc)) {
                $currentValues = ItemsProcFunc::decodeUserParameters($result['databaseRow']);
                $wizardFields = ItemsProcFunc::callWizardFields($itemsProcFunc, $pObj);
                $fieldPrefix = 'tx_directmailuserfunc_virtual_';

                foreach ($wizardFields['columns'] as $field => $_) {
                    $tcaField = $fieldPrefix . $field;
                    $result['databaseRow'][$tcaField] = $currentValues[$field] ?? '';
                }
            }
        }

        return $result;
    }

}
