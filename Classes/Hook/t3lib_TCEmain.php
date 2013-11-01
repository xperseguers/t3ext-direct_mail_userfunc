<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Xavier Perseguers (xavier@causal.ch)
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
 * This class hooks into t3lib_TCEmain to process the virtual fields and serialize them.
 *
 * @category    Hook
 * @package     direct_mail_userfunc
 * @author      Xavier Perseguers <xavier@causal.ch>
 * @copyright   2013 Causal Sàrl
 * @license     http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_DirectMailUserfuncTcemain {

	/**
	 * Stores virtual field values into column tx_directmailuserfunc_params.
	 *
	 * @param array $incomingFieldArray
	 * @param string $table
	 * @param integer|string $id
	 * @param t3lib_TCEmain $pObj
	 * @return void
	 */
	public function processDatamap_preProcessFieldArray(array &$incomingFieldArray, $table, $id, t3lib_TCEmain $pObj) {
		if ($table !== 'sys_dmail_group') {
			return;
		}

		$virtualValues = array();
		foreach ($incomingFieldArray as $field => $value) {
			if (t3lib_div::isFirstPartOfStr($field, 'tx_directmailuserfunc_virtual_')) {
				$virtualField = substr($field, strlen('tx_directmailuserfunc_virtual_'));
				$virtualValues[$virtualField] = $value;
				unset($incomingFieldArray[$field]);
			}
		}

		if (count($virtualValues) > 0) {
			$row = t3lib_BEfunc::getRecord($table, $id);
			$currentValues = !empty($row['tx_directmailuserfunc_params'])
				? json_decode($row['tx_directmailuserfunc_params'], TRUE)
				: array();
			if (!is_array($currentValues)) {
				$currentValues = array();
			}

			$newValues = array_merge($currentValues, $virtualValues);
			$incomingFieldArray['tx_directmailuserfunc_params'] = json_encode($newValues);
		}
	}

}
