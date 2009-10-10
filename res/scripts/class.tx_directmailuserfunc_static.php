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


require_once(t3lib_extMgm::extPath('direct_mail_userfunc') . 'res/scripts/class.tx_directmailuserfunc_static.php');

/**
 * Static class with a few helper functions.
 *
 * $Id$
 */
class tx_directmailuserfunc_static {

	/**
	 * Returns the TSconfig of a given DirectMail sysfolder as an array of key/value pairs.
	 *  
	 * @param $pObj
	 * @return array
	 */
	public static function getTSconfig($pObj) {
		$pageTS = $pObj->pageinfo['TSconfig'];
		$lines = explode("\n", $pageTS);
		$config = array();

		foreach ($lines as $line) {
			$line = trim($line);
			if (empty($line) || $line{0} === '#') {
				continue;
			}
			list($key, $value) = t3lib_div::trimExplode('=', $line);
			$config[$key] = $value;
		}
		return $config;
	}
	
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/direct_mail_userfunc/res/scripts/class.tx_directmailuserfunc_static.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/direct_mail_userfunc/res/scripts/class.tx_directmailuserfunc_static.php']);
}

?>