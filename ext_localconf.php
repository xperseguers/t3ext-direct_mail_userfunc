<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// Register XCLASS to process recipient lists based on a user function
$GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/direct_mail/mod2/class.tx_directmail_dmail.php'] = t3lib_extMgm::extPath($_EXTKEY) . 'Classes/Xclass/class.ux_tx_directmail_dmail.php';
$GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/direct_mail/mod3/class.tx_directmail_recipient_list.php'] = t3lib_extMgm::extPath($_EXTKEY) . 'Classes/Xclass/class.ux_tx_directmail_recipient_list.php';

if (version_compare(TYPO3_version, '6.2.0', '>=')) {
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['DirectMailTeam\\DirectMail\\Mod2\\tx_directmail_dmail'] = array(
		'className' => 'ux_tx_directmail_dmail',
	);
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['DirectMailTeam\\DirectMail\\Mod3\\tx_directmail_recipient_list'] = array(
		'className' => 'ux_tx_directmail_recipient_list',
	);
} else {
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['tx_directmail_dmail'] = array(
		'className' => 'ux_tx_directmail_dmail',
	);
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['tx_directmail_recipient_list'] = array(
		'className' => 'ux_tx_directmail_recipient_list',
	);
}
