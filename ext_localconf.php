<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// Register XCLASS to process recipient lists based on a user function
$TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/direct_mail/mod2/class.tx_directmail_dmail.php'] = t3lib_extMgm::extPath($_EXTKEY) . 'xclass/class.ux_tx_directmail_dmail.php';
$TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/direct_mail/mod3/class.tx_directmail_recipient_list.php'] = t3lib_extMgm::extPath($_EXTKEY) . 'xclass/class.ux_tx_directmail_recipient_list.php';

// Include wizard class
include_once(t3lib_extMgm::extPath($_EXTKEY) . 'controller/class.tx_directmailuserfunc_wizard.php');

// Include sample user functions if needed
if (TYPO3_MODE === 'BE') {
	$extConf = unserialize($TYPO3_CONF_VARS['EXT']['extConf']['direct_mail_userfunc']);
	if ($extConf['enableSamples']) {
		include_once(t3lib_extMgm::extPath($_EXTKEY) . 'samples/user_testlist.php');

		if (strcmp(substr(TYPO3_version, 0, 3), '4.3') >= 0) {
			include_once(t3lib_extMgm::extPath($_EXTKEY) . 'samples/user_testlist_extjs.php');
		}
	}
}

?>