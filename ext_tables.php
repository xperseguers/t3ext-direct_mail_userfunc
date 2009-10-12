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
			'size' => '30',
			'wizards' => array(
				'uproc' => array(
					'type' => 'userFunc',
					'userFunc' => 'tx_directmailuserfunc_wizard->user_TCAform_procWizard',
					'params' => array(),
				),
			),
		)
	),
);

t3lib_div::loadTCA('sys_dmail_group');
t3lib_extMgm::addTCAcolumns('sys_dmail_group',$tempColumns, 1);

$TCA['sys_dmail_group']['columns']['type']['config']['items'][] = array('LLL:EXT:direct_mail_userfunc/locallang_tca.xml:sys_dmail_group.type.I.5', '5');
$TCA['sys_dmail_group']['types']['5'] = array('showitem' => 'type;;;;1-1-1, title;;;;3-3-3, description, tx_directmailuserfunc_itemsprocfunc;;;;5-5-5');
?>