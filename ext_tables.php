<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$tempColumns = array(
	'tx_directmailuserfunc_itemsprocfunc' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:direct_mail_userfunc/Resources/Private/Language/locallang_db.xml:sys_dmail_group.tx_directmailuserfunc_itemsprocfunc',
		'config' => array(
			'type' => 'input',
			'size' => '40',
			'wizards' => array(
				'uproc' => array(
					'type' => 'userFunc',
					'userFunc' => 'Tx_DirectMailUserfunc_Controller_Wizard->itemsprocfunc_procWizard',
					'params' => array(),
				),
			),
		)
	),
	'tx_directmailuserfunc_params' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:direct_mail_userfunc/Resources/Private/Language/locallang_db.xml:sys_dmail_group.tx_directmailuserfunc_params',
		'config' => array(
			'type' => 'text',
			'cols' => '40',
			'rows' => '2',
			'wizards' => array(
				'uproc' => array(
					'type' => 'userFunc',
					'userFunc' => 'Tx_DirectMailUserfunc_Controller_Wizard->params_procWizard',
					'params' => array(),
				),
			),
		)
	),
);

if (version_compare(TYPO3_version, '6.1.0', '<')) {
	t3lib_div::loadTCA('sys_dmail_group');
}
t3lib_extMgm::addTCAcolumns('sys_dmail_group', $tempColumns, 1);

$GLOBALS['TCA']['sys_dmail_group']['columns']['type']['config']['items'][] = array('LLL:EXT:direct_mail_userfunc/Resources/Private/Language/locallang_tca.xml:sys_dmail_group.type.I.5', '5');
$GLOBALS['TCA']['sys_dmail_group']['types']['5'] = array('showitem' => 'type;;;;1-1-1, title;;;;3-3-3, description, tx_directmailuserfunc_itemsprocfunc;;;;5-5-5, tx_directmailuserfunc_params;;;;7-7-7');

if (!isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['direct_mail_userfunc'])) {
	// Allow extensions to register themselves as userfunc providers
	$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['direct_mail_userfunc']['userFunc'] = array();
}

// Register hook into t3lib_TCEforms
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tceforms.php']['getMainFieldsClass'][] = 'EXT:' . $_EXTKEY . '/Classes/Hook/t3lib_TCEforms.php:Tx_DirectMailUserfuncTceforms';

// Register hook into t3lib_TCEmain
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'EXT:' . $_EXTKEY . '/Classes/Hook/t3lib_TCEmain.php:Tx_DirectMailUserfuncTcemain';

// Register sample user functions if needed
if (TYPO3_MODE === 'BE') {
	$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['direct_mail_userfunc']);
	if ($extConf['enableSamples']) {
		$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['direct_mail_userfunc']['userFunc'][] = array(
			'class'  => 'user_testList',
			'method' => 'myRecipientList',
			'label'  => 'LLL:EXT:direct_mail_userfunc/Resources/Private/Language/locallang.xml:userfunction.myRecipientList'
		);

		$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['direct_mail_userfunc']['userFunc'][] = array(
			'class'  => 'user_testList_extjs',
			'method' => 'myRecipientList',
			'label'  => 'LLL:EXT:direct_mail_userfunc/Resources/Private/Language/locallang.xml:userfunction.myRecipientListExtJS'
		);

		$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['direct_mail_userfunc']['userFunc'][] = array(
			'class'  => 'user_testList_tca',
			'method' => 'myRecipientList',
			'label'  => 'LLL:EXT:direct_mail_userfunc/Resources/Private/Language/locallang.xml:userfunction.myRecipientListTca'
		);
	}
}

?>