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
 * This class hooks into t3lib_TCEforms to process the virtual fields.
 *
 * @category    Hook
 * @package     direct_mail_userfunc
 * @author      Xavier Perseguers <xavier@causal.ch>
 * @copyright   2013 Causal Sàrl
 * @license     http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_DirectMailUserfuncTceforms {

	/**
	 * Pre-processes the TCA of table sys_dmail_group.
	 *
	 * @param string $table
	 * @param array $row
	 * @param t3lib_TCEforms $pObj
	 * @return void
	 */
	public function getMainFields_preProcess($table, array &$row, t3lib_TCEforms $pObj) {
		if ($table !== 'sys_dmail_group') {
			return;
		}

		$wizardFields = NULL;
		$itemsProcFunc = $row['tx_directmailuserfunc_itemsprocfunc'];
		if (!empty($itemsProcFunc) && Tx_DirectMailUserfunc_Controller_Wizard::isMethodValid($itemsProcFunc)) {
			list($className, $methodName) = explode('->', $itemsProcFunc);
			if (method_exists($className, 'getWizardFields')) {
				$wizardFields = call_user_func_array(
					array($className, 'getWizardFields'),
					array($methodName, $pObj)
				);
				$this->reconfigureTCA($wizardFields, $row);
			}
		}
	}

	/**
	 * Reconfigures the TCA with custom fields.
	 *
	 * @param array $fields
	 * @param array $row
	 * @return void
	 */
	protected function reconfigureTCA(array $fields, array &$row) {
		$currentValues = !empty($row['tx_directmailuserfunc_params'])
			? json_decode($row['tx_directmailuserfunc_params'], TRUE)
			: array();
		if (!is_array($currentValues)) {
			$currentValues = array();
		}

		// Prefix each additional field
		$prefixedFields = array(
			'columns' => array(),
			'types' => $fields['types'],
			'palettes' => isset($fields['palettes']) ? $fields['palettes'] : array(),
		);
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
		}

		// Remove standard textarea
		unset($GLOBALS['TCA']['sys_dmail_group']['columns']['tx_directmailuserfunc_params']);

		// Reconfigure TCA with virtual fields
		foreach ($prefixedFields['columns'] as $field => $fieldInfo) {
			$GLOBALS['TCA']['sys_dmail_group']['columns'][$field] = $fieldInfo;
		}

		foreach ($prefixedFields['types'] as $type => $typeInfo) {
			$GLOBALS['TCA']['sys_dmail_group']['types'][$type]['showitem'] .= ',' . $typeInfo['showitem'];
		}

		// sys_dmail_group has no initial palettes
		$GLOBALS['TCA']['sys_dmail_group']['palettes'] = $prefixedFields['palettes'];
	}

}
