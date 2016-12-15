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
 * This class hooks into direct_mail to post-process the list of recipients.
 *
 * @category    Hook
 * @package     direct_mail_userfunc
 * @author      Xavier Perseguers <xavier@causal.ch>
 * @copyright   2014-2016 Causal Sàrl
 * @license     https://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class DirectMail
{

    /**
     * Post-processes the list of recipients.
     *
     * @param array $id_lists
     * @param \DirectMailTeam\DirectMail\Module\RecipientList|\DirectMailTeam\DirectMail\Module\Dmail $pObj parent object
     * @param array $groups
     * @return array
     */
    public function cmd_compileMailGroup_postProcess(array $id_lists, $pObj, array $groups)
    {
        $mailGroups = [];

        if (!isset($groups['uid'])) {
            // Coming from mod2 (Dmail)
            foreach ($groups as $group) {
                \TYPO3\CMS\Core\Utility\MathUtility::convertToPositiveInteger($group);
                if (!$group) {
                    continue;
                }

                $mailGroup = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord('sys_dmail_group', $group);
                if (is_array($mailGroup)) {
                    $mailGroups[] = $mailGroup;
                }
            }
        } else {
            // Coming from mod5 (RecipientList)
            $mailGroups[] = $groups;
        }

        foreach ($mailGroups as $mailGroup) {
            if ((int)$mailGroup['type'] === 5) {
                $recipientList = $this->generateRecipientList($mailGroup, $pObj);
                $id_lists = array_merge_recursive($id_lists, $recipientList);
            }
        }

        return $id_lists;
    }

    /**
     * Generates the list of recipients.
     *
     * @param array $mailGroup
     * @param object $pObj parent object
     * @return array
     */
    protected function generateRecipientList(array $mailGroup, $pObj)
    {
        $recipientList = [
            'tt_address' => [],
            'fe_users' => [],
            'PLAINLIST' => [],
        ];
        $itemsProcFunc = $mailGroup['tx_directmailuserfunc_itemsprocfunc'];
        if (ItemsProcFunc::isMethodValid($itemsProcFunc)) {
            $userParams = $mailGroup['tx_directmailuserfunc_params'];
            if (ItemsProcFunc::hasWizardFields($itemsProcFunc)) {
                $fields = ItemsProcFunc::callWizardFields($itemsProcFunc);
                if ($fields !== null) {
                    $userParams = count($fields) === 0
                        ? []
                        : ItemsProcFunc::decodeUserParameters($mailGroup);
                }
            }

            $params = [
                'groupUid' => $mailGroup['uid'],
                'lists' => &$recipientList,
                'userParams' => $userParams,
            ];
            GeneralUtility::callUserFunction($itemsProcFunc, $params, $pObj);

            $extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['direct_mail_userfunc']);
            if (!isset($extConf['makeEntriesUnique']) || $extConf['makeEntriesUnique'] == 1) {
                // Make unique entries
                $recipientList['tt_address'] = array_unique($recipientList['tt_address']);
                $recipientList['fe_users'] = array_unique($recipientList['fe_users']);
                $recipientList['PLAINLIST'] = \DirectMailTeam\DirectMail\DirectMailUtility::cleanPlainList($recipientList['PLAINLIST']);
            }
        }

        return $recipientList;
    }

}
