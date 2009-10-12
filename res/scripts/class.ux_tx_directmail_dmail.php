<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Xavier Perseguers (typo3@perseguers.ch)
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
 * $Id$
 */
class ux_tx_directmail_dmail extends tx_directmail_dmail {

	/**
	 * Gets the recipient IDs given only the group ID
	 *
	 * @param integer $group_uid: recipient group ID
	 * @return array list of the recipient ID
	 */
	public function cmd_compileMailGroup($group_uid) {
		$id_lists = array(
			'tt_address' => array(),
			'fe_users'   => array(),
			'PLAINLIST'  => array(),
		);
		if ($group_uid) {
			$mailGroup = t3lib_BEfunc::getRecord('sys_dmail_group', $group_uid);
			if (is_array($mailGroup) && $mailGroup['pid'] == $this->id) {
				switch ($mailGroup['type']) {
					case 5:
						$itemsProcFunc = $mailGroup['tx_directmailuserfunc_itemsprocfunc'];
						if ($itemsProcFunc) {
							$params = array(
								'groupUid'  => $group_uid,
								'PLAINLIST' => &$id_lists['PLAINLIST'],
							);
							t3lib_div::callUserFunction($itemsProcFunc, $params, $this);
							$id_lists['PLAINLIST'] = tx_directmail_static::cleanPlainList($id_lists['PLAINLIST']);
						}
						break;
				default:
					return parent::cmd_compileMailGroup($group_uid);		
				}
			}
		}

		// TODO: support hook from parent method?

		$outputArray = array(
			'queryInfo' => array('id_lists' => $id_lists)
		);
		return $outputArray;
	}

}

?>