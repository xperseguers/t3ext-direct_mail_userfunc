<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012-2013 Xavier Perseguers (xavier@causal.ch)
 *  (c) 2009-2011 Xavier Perseguers (typo3@perseguers.ch)
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * This class extends EXT:direct_mail to let recipient lists to be
 * defined by a user function.
 *
 * @category    XCLASS
 * @package     direct_mail_userfunc
 * @author      Xavier Perseguers <xavier@causal.ch>
 * @copyright   2012-2013 Causal Sàrl
 * @license     http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class ux_tx_directmail_dmail extends tx_directmail_dmail {

	/**
	 * Gets the recipient IDs given only the group ID.
	 *
	 * Invoked when reaching step 4 of sending a Direct Mail (number of recipients by list)
	 * from method "cmd_finalmail" and then when clicking on "send" (to schedule the delivery)
	 * from method "cmd_send_mail".
	 *
	 * @param array $groups array of recipient group ID
	 * @return array list of the recipient ID
	 */
	public function cmd_compileMailGroup(array $groups) {
		//$callers = debug_backtrace();
		//$caller = $callers[1]['function'];

		// If supplied with an empty array, quit instantly as there is nothing to do
		if (!count($groups)) {
			return;
		}

		// Looping through the selected array, in order to fetch recipient details
		$id_lists = array(
			'tt_address' => array(),
			'fe_users' => array(),
			'PLAINLIST' => array(),
		);
		foreach ($groups AS $group) {
			// Testing to see if group ID is a valid integer, if not - skip to next group ID
			if (t3lib_div::compat_version('4.6')) {
				$group = t3lib_utility_Math::convertToPositiveInteger($group);
			} else {
				$group = t3lib_div::intval_positive($group);
			}
			if (!$group) {
				continue;
			}

			$mailGroup = t3lib_BEfunc::getRecord('sys_dmail_group', $group);
			if (is_array($mailGroup) && $mailGroup['pid'] == $this->id) {
				switch ($mailGroup['type']) {
					case 5:
						$recipientList = array(
							'tt_address' => array(),
							'fe_users' => array(),
							'PLAINLIST' => array(),
						);
						$itemsProcFunc = $mailGroup['tx_directmailuserfunc_itemsprocfunc'];
						if ($itemsProcFunc) {
							$params = array(
								'groupUid' => $group,
								'lists' => &$recipientList,
								'userParams' => $mailGroup['tx_directmailuserfunc_params'],
							);
							t3lib_div::callUserFunction($itemsProcFunc, $params, $this);

							$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['direct_mail_userfunc']);
							if (!isset($extConf['makeEntriesUnique']) || $extConf['makeEntriesUnique'] == 1) {
								// Make unique entries
								$recipientList['tt_address'] = array_unique($recipientList['tt_address']);
								$recipientList['fe_users'] = array_unique($recipientList['fe_users']);
								$recipientList['PLAINLIST'] = tx_directmail_static::cleanPlainList($recipientList['PLAINLIST']);
							}
						}
						break;
					default:
						return parent::cmd_compileMailGroup(array($group));
						break;
				}
				$id_lists = array_merge_recursive($id_lists, $recipientList);
			}
		}

		// TODO: support hook from parent method?
		$outputArray = array(
			'queryInfo' => array('id_lists' => $id_lists)
		);
		return $outputArray;
	}

}
