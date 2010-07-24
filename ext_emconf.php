<?php

########################################################################
# Extension Manager/Repository config file for ext: "direct_mail_userfunc"
#
# Auto generated 28-10-2009 11:26
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
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => 'sys_dmail_group',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '1.2.1',
	'doNotLoadInFE' => 1,
	'constraints' => array(
		'depends' => array(
			'php' => '5.2.0-0.0.0',
			'typo3' => '4.2.0-4.4.99',
			'direct_mail' => '2.6.3-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:17:{s:9:"ChangeLog";s:4:"468c";s:10:"README.txt";s:4:"1a6e";s:21:"ext_conf_template.txt";s:4:"4456";s:12:"ext_icon.gif";s:4:"7050";s:17:"ext_localconf.php";s:4:"c4cb";s:14:"ext_tables.php";s:4:"f0ab";s:14:"ext_tables.sql";s:4:"4c70";s:13:"locallang.xml";s:4:"f868";s:16:"locallang_db.xml";s:4:"5d6a";s:17:"locallang_tca.xml";s:4:"59ce";s:49:"controller/class.tx_directmailuserfunc_wizard.php";s:4:"d8b2";s:14:"doc/manual.sxw";s:4:"7c4e";s:39:"xclass/class.ux_tx_directmail_dmail.php";s:4:"e5a3";s:48:"xclass/class.ux_tx_directmail_recipient_list.php";s:4:"60ed";s:21:"samples/parameters.js";s:4:"9475";s:25:"samples/user_testlist.php";s:4:"380a";s:31:"samples/user_testlist_extjs.php";s:4:"2084";}',
	'suggests' => array(
	),
);

?>