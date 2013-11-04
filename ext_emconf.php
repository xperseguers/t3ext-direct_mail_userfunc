<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "direct_mail_userfunc".
 *
 * Auto generated 11-10-2013 14:18
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'External Providers for Direct Mail',
	'description' => 'Adds support for external providers to Direct Mail. This extension extends the types of recipient lists handled by Direct Mail with an entry for parameterized custom lists. These custom lists are prepared by user functions and may easily reuse your own business logic.',
	'category' => 'module',
	'author' => 'Xavier Perseguers (Causal)',
	'author_company' => 'Causal Sàrl',
	'author_email' => 'xavier@causal.ch',
	'shy' => '',
	'dependencies' => 'direct_mail',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => 'sys_dmail,sys_dmail_group',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '1.4.0',
	'constraints' => array(
		'depends' => array(
			'php' => '5.3.7-5.4.99',
			'typo3' => '4.5.0-6.1.99',
			'direct_mail' => '3.0.0-4.0.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:51:{s:9:"ChangeLog";s:4:"2e5c";s:21:"ext_conf_template.txt";s:4:"a9e1";s:12:"ext_icon.gif";s:4:"7050";s:17:"ext_localconf.php";s:4:"217e";s:14:"ext_tables.php";s:4:"0683";s:14:"ext_tables.sql";s:4:"303b";s:13:"locallang.xml";s:4:"348e";s:16:"locallang_db.xml";s:4:"5d6a";s:17:"locallang_tca.xml";s:4:"4b35";s:26:"Documentation/Includes.txt";s:4:"c83c";s:23:"Documentation/Index.rst";s:4:"c8a4";s:26:"Documentation/Settings.yml";s:4:"65fd";s:25:"Documentation/Targets.rst";s:4:"94c2";s:33:"Documentation/ChangeLog/Index.rst";s:4:"b4d9";s:39:"Documentation/DeveloperManual/Index.rst";s:4:"ebe9";s:61:"Documentation/DeveloperManual/AdditionalParameters/Images.txt";s:4:"5dd3";s:60:"Documentation/DeveloperManual/AdditionalParameters/Index.rst";s:4:"7710";s:67:"Documentation/DeveloperManual/RegisteringTheUserFunction/Images.txt";s:4:"0e16";s:66:"Documentation/DeveloperManual/RegisteringTheUserFunction/Index.rst";s:4:"7065";s:60:"Documentation/DeveloperManual/SampleUserFunctions/Images.txt";s:4:"496e";s:59:"Documentation/DeveloperManual/SampleUserFunctions/Index.rst";s:4:"3613";s:76:"Documentation/DeveloperManual/UsingAWizardForAdditionalParameters/Images.txt";s:4:"9a4f";s:75:"Documentation/DeveloperManual/UsingAWizardForAdditionalParameters/Index.rst";s:4:"7ff9";s:42:"Documentation/FurtherInformation/Index.rst";s:4:"83b2";s:46:"Documentation/Images/additional_parameters.png";s:4:"cad6";s:36:"Documentation/Images/alert_basic.png";s:4:"6f33";s:36:"Documentation/Images/alert_extjs.png";s:4:"66b8";s:39:"Documentation/Images/enable_samples.png";s:4:"c741";s:38:"Documentation/Images/invalid_class.png";s:4:"1d1c";s:39:"Documentation/Images/invalid_method.png";s:4:"db7a";s:38:"Documentation/Images/itemsprocfunc.png";s:4:"2dcc";s:37:"Documentation/Images/new_provider.png";s:4:"c9de";s:45:"Documentation/Images/number_of_recipients.png";s:4:"82a2";s:45:"Documentation/Images/registered_providers.png";s:4:"9e65";s:40:"Documentation/Images/supported_types.png";s:4:"d656";s:38:"Documentation/Images/type_userfunc.png";s:4:"69af";s:42:"Documentation/Images/userfunc_overview.png";s:4:"fdbb";s:30:"Documentation/Images/valid.png";s:4:"6b7a";s:31:"Documentation/Images/wizard.png";s:4:"3700";s:37:"Documentation/Introduction/Images.txt";s:4:"2dff";s:36:"Documentation/Introduction/Index.rst";s:4:"1a9a";s:37:"Documentation/KnownProblems/Index.rst";s:4:"0588";s:32:"Documentation/ToDoList/Index.rst";s:4:"cf8d";s:36:"Documentation/UsersManual/Images.txt";s:4:"13d8";s:35:"Documentation/UsersManual/Index.rst";s:4:"e94d";s:49:"controller/class.tx_directmailuserfunc_wizard.php";s:4:"e8f7";s:21:"samples/parameters.js";s:4:"9475";s:25:"samples/user_testlist.php";s:4:"3780";s:31:"samples/user_testlist_extjs.php";s:4:"ab8a";s:39:"xclass/class.ux_tx_directmail_dmail.php";s:4:"ad3f";s:48:"xclass/class.ux_tx_directmail_recipient_list.php";s:4:"ef9c";}',
	'suggests' => array(
	),
);

?>