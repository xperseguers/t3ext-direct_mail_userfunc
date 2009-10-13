<?php

########################################################################
# Extension Manager/Repository config file for ext: "direct_mail_userfunc"
#
# Auto generated 13-10-2009 09:34
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Direct Mail User Functions',
	'description' => 'Adds support for user functions to Direct Mail. Currently allows recipient lists to be defined using a user function.',
	'category' => 'module',
	'author' => 'Xavier Perseguers',
	'author_email' => 'typo3@perseguers.ch',
	'shy' => '',
	'dependencies' => 'direct_mail',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => 'sys_dmail_group',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.2.1',
	'doNotLoadInFE' => 1,
	'constraints' => array(
		'depends' => array(
			'php' => '5.2.0-0.0.0',
			'typo3' => '4.2.0-4.3.99',
			'direct_mail' => '2.6.3-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:13:{s:9:"ChangeLog";s:4:"3b7b";s:10:"README.txt";s:4:"1a6e";s:12:"ext_icon.gif";s:4:"a143";s:17:"ext_localconf.php";s:4:"eaf3";s:14:"ext_tables.php";s:4:"0d9f";s:14:"ext_tables.sql";s:4:"f418";s:16:"locallang_db.xml";s:4:"284e";s:17:"locallang_tca.xml";s:4:"9a64";s:14:"doc/manual.sxw";s:4:"315e";s:50:"res/scripts/class.tx_directmailuserfunc_wizard.php";s:4:"ee35";s:44:"res/scripts/class.ux_tx_directmail_dmail.php";s:4:"0820";s:53:"res/scripts/class.ux_tx_directmail_recipient_list.php";s:4:"5984";s:25:"samples/user_testlist.php";s:4:"6f61";}',
	'suggests' => array(
	),
);

?>