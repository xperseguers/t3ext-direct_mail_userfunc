<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// Register hooks to process recipient lists based on a user function
//$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['direct_mail']['mod2']['cmd_compileMailGroup'][] = 'EXT:direct_mail_userfunc/class.user_tx_directmail_hook.php:user_tx_directmail_hook';

$TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/direct_mail/mod3/class.tx_directmail_recipient_list.php'] = t3lib_extMgm::extPath($_EXTKEY) . 'res/scripts/class.ux_tx_directmail_recipient_list.php';

include(t3lib_extMgm::extPath($_EXTKEY) . 'samples/user_testlist.php');
?>