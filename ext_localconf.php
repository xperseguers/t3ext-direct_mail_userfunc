<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// Register XCLASS to process recipient lists based on a user function
$TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/direct_mail/mod2/class.tx_directmail_dmail.php'] = t3lib_extMgm::extPath($_EXTKEY) . 'res/scripts/class.ux_tx_directmail_dmail.php';
$TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/direct_mail/mod3/class.tx_directmail_recipient_list.php'] = t3lib_extMgm::extPath($_EXTKEY) . 'res/scripts/class.ux_tx_directmail_recipient_list.php';

// Include wizard class
include(t3lib_extMgm::extPath($_EXTKEY) . 'res/scripts/class.tx_directmailuserfunc_wizard.php');

// Uncomment next line to get a sample user function to be used with
// "user_testList->myRecipientList" as itemsProcFunc value
//include(t3lib_extMgm::extPath($_EXTKEY) . 'samples/user_testlist.php');

// If you run TYPO3 4.3, ExtJS is available and you may uncomment next line instead
// and will then have to use "user_testlist_extjs->myRecipientList" as itemsProcFunc value
//include(t3lib_extMgm::extPath($_EXTKEY) . 'samples/user_testlist_extjs.php');
?>