<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$tempColumns = array(
	'tx_directmailuserfunc_itemsprocfunc' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:direct_mail_userfunc/locallang_db.xml:sys_dmail_group.tx_directmailuserfunc_itemsprocfunc',
		'config' => array(
			'type' => 'input',
			'size' => '40',
			'wizards' => array(
				'uproc' => array(
					'type' => 'userFunc',
					'userFunc' => 'tx_directmailuserfunc_wizard->itemsprocfunc_procWizard',
					'params' => array(),
				),
			),
		)
	),
	'tx_directmailuserfunc_params' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:direct_mail_userfunc/locallang_db.xml:sys_dmail_group.tx_directmailuserfunc_params',
		'config' => array(
			'type' => 'text',
			'cols' => '40',
			'rows' => '2',
			'wizards' => array(
				'uproc' => array(
					'type' => 'userFunc',
					'userFunc' => 'tx_directmailuserfunc_wizard->params_procWizard',
					'params' => array(),
				),
			),
		)
	),
);

t3lib_div::loadTCA('sys_dmail_group');
t3lib_extMgm::addTCAcolumns('sys_dmail_group', $tempColumns, 1);

$TCA['sys_dmail_group']['columns']['type']['config']['items'][] = array('LLL:EXT:direct_mail_userfunc/locallang_tca.xml:sys_dmail_group.type.I.5', '5');
$TCA['sys_dmail_group']['types']['5'] = array('showitem' => 'type;;;;1-1-1, title;;;;3-3-3, description, tx_directmailuserfunc_itemsprocfunc;;;;5-5-5, tx_directmailuserfunc_params;;;;7-7-7');

// Allow extensions to register themselves as userfunc providers
$TYPO3_CONF_VARS['EXTCONF']['direct_mail_userfunc']['userFunc'] = array();

// Register sample user functions if needed
if (TYPO3_MODE === 'BE') {
	$extConf = unserialize($TYPO3_CONF_VARS['EXT']['extConf']['direct_mail_userfunc']);
	if ($extConf['enableSamples']) {
		$TYPO3_CONF_VARS['EXTCONF']['direct_mail_userfunc']['userFunc'][] = array(
			'class'  => 'user_testList',
			'method' => 'myRecipientList',
			'label'  => 'LLL:EXT:direct_mail_userfunc/locallang.xml:userfunction.myRecipientList'
		);

		if (strcmp(substr(TYPO3_version, 0, 3), '4.3') >= 0) {
			$TYPO3_CONF_VARS['EXTCONF']['direct_mail_userfunc']['userFunc'][] = array(
				'class'  => 'user_testList_extjs',
				'method' => 'myRecipientList',
				'label'  => 'LLL:EXT:direct_mail_userfunc/locallang.xml:userfunction.myRecipientListExtJS'
			);
		}
	}
}
?>
