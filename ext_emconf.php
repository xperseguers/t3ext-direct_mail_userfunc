<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "direct_mail_userfunc".
 *
 * Auto generated 17-06-2014 20:29
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
	'version' => '1.4.3-dev',
	'constraints' => array(
		'depends' => array(
			'php' => '5.3.7-5.5.99',
			'typo3' => '4.5.0-6.2.99',
			'direct_mail' => '3.1.0-4.0.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:50:{s:16:"ext_autoload.php";s:4:"cd50";s:21:"ext_conf_template.txt";s:4:"dbf8";s:12:"ext_icon.gif";s:4:"7050";s:14:"ext_tables.php";s:4:"b352";s:14:"ext_tables.sql";s:4:"303b";s:29:"Classes/Controller/Wizard.php";s:4:"1ccc";s:27:"Classes/Hook/DirectMail.php";s:4:"fe17";s:20:"Classes/Hook/Tce.php";s:4:"314b";s:29:"Classes/Samples/parameters.js";s:4:"3020";s:28:"Classes/Samples/TestList.php";s:4:"0d9d";s:33:"Classes/Samples/TestListExtjs.php";s:4:"7e0e";s:31:"Classes/Samples/TestListTca.php";s:4:"e435";s:33:"Classes/Utility/ItemsProcFunc.php";s:4:"2e98";s:26:"Documentation/Includes.txt";s:4:"c83c";s:23:"Documentation/Index.rst";s:4:"456e";s:26:"Documentation/Settings.yml";s:4:"fb2b";s:25:"Documentation/Targets.rst";s:4:"94c2";s:33:"Documentation/ChangeLog/Index.rst";s:4:"cf54";s:39:"Documentation/DeveloperManual/Index.rst";s:4:"0c80";s:60:"Documentation/DeveloperManual/AdditionalParameters/Index.rst";s:4:"6912";s:58:"Documentation/DeveloperManual/AdditionalParameters/TCA.rst";s:4:"b5da";s:61:"Documentation/DeveloperManual/AdditionalParameters/Wizard.rst";s:4:"7547";s:66:"Documentation/DeveloperManual/RegisteringTheUserFunction/Index.rst";s:4:"c7dd";s:59:"Documentation/DeveloperManual/SampleUserFunctions/Index.rst";s:4:"6c33";s:42:"Documentation/FurtherInformation/Index.rst";s:4:"83b2";s:46:"Documentation/Images/additional_parameters.png";s:4:"e868";s:36:"Documentation/Images/alert_basic.png";s:4:"6f33";s:36:"Documentation/Images/alert_extjs.png";s:4:"3ce7";s:39:"Documentation/Images/enable_samples.png";s:4:"c741";s:38:"Documentation/Images/invalid_class.png";s:4:"5fe1";s:39:"Documentation/Images/invalid_method.png";s:4:"86d3";s:38:"Documentation/Images/itemsprocfunc.png";s:4:"adff";s:37:"Documentation/Images/new_provider.png";s:4:"c9de";s:45:"Documentation/Images/number_of_recipients.png";s:4:"016b";s:45:"Documentation/Images/registered_providers.png";s:4:"9e65";s:40:"Documentation/Images/supported_types.png";s:4:"609f";s:28:"Documentation/Images/tca.png";s:4:"f9ce";s:38:"Documentation/Images/type_userfunc.png";s:4:"f951";s:42:"Documentation/Images/userfunc_overview.png";s:4:"9e03";s:30:"Documentation/Images/valid.png";s:4:"6b7a";s:31:"Documentation/Images/wizard.png";s:4:"3700";s:36:"Documentation/Introduction/Index.rst";s:4:"8d76";s:37:"Documentation/KnownProblems/Index.rst";s:4:"0588";s:35:"Documentation/UsersManual/Index.rst";s:4:"5743";s:40:"Resources/Private/Language/locallang.xlf";s:4:"1d2f";s:40:"Resources/Private/Language/locallang.xml";s:4:"474f";s:43:"Resources/Private/Language/locallang_db.xlf";s:4:"8b82";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"b94d";s:44:"Resources/Private/Language/locallang_tca.xlf";s:4:"444f";s:44:"Resources/Private/Language/locallang_tca.xml";s:4:"8596";}',
	'suggests' => array(
	),
);

?>