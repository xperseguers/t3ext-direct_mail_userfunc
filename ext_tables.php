<?php
defined('TYPO3_MODE') || die();

$tempColumns = [
    'tx_directmailuserfunc_itemsprocfunc' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:direct_mail_userfunc/Resources/Private/Language/locallang_db.xlf:sys_dmail_group.tx_directmailuserfunc_itemsprocfunc',
        'config' => [
            'type' => 'input',
            'size' => '40',
            'wizards' => [
                'uproc' => [
                    'type' => 'userFunc',
                    'userFunc' => \Causal\DirectMailUserfunc\Controller\Wizard::class . '->itemsprocfunc_procWizard',
                    'params' => [],
                ],
            ],
        ]
    ],
    'tx_directmailuserfunc_params' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:direct_mail_userfunc/Resources/Private/Language/locallang_db.xlf:sys_dmail_group.tx_directmailuserfunc_params',
        'config' => [
            'type' => 'text',
            'cols' => '40',
            'rows' => '2',
            'wizards' => [
                'uproc' => [
                    'type' => 'userFunc',
                    'userFunc' => \Causal\DirectMailUserfunc\Controller\Wizard::class . '->params_procWizard',
                    'params' => [],
                ],
            ],
        ]
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_dmail_group', $tempColumns);

$GLOBALS['TCA']['sys_dmail_group']['columns']['type']['config']['items'][] = [
    'LLL:EXT:direct_mail_userfunc/Resources/Private/Language/locallang_tca.xlf:sys_dmail_group.type.I.5', '5'
];
$GLOBALS['TCA']['sys_dmail_group']['types']['5'] = [
    'showitem' => 'type;;;;1-1-1, title;;;;3-3-3, description, tx_directmailuserfunc_itemsprocfunc;;;;5-5-5, tx_directmailuserfunc_params;;;;7-7-7'
];

if (!isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['direct_mail_userfunc'])) {
    // Allow extensions to register themselves as userfunc providers
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['direct_mail_userfunc']['userFunc'] = [];
}

// Register hook into direct_mail
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['direct_mail']['mod2']['cmd_compileMailGroup'][] = \Causal\DirectMailUserfunc\Hook\DirectMail::class;
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['direct_mail']['mod3']['cmd_compileMailGroup'][] = \Causal\DirectMailUserfunc\Hook\DirectMail::class;

// Register hook into \TYPO3\CMS\Backend\Form\FormEngine and \TYPO3\CMS\Core\DataHandling\DataHandler
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tceforms.php']['getMainFieldsClass'][] = \Causal\DirectMailUserfunc\Hook\Tce::class;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = \Causal\DirectMailUserfunc\Hook\Tce::class;

// Register sample user functions if needed
if (TYPO3_MODE === 'BE') {
    $extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['direct_mail_userfunc']);
    if ($extConf['enableSamples']) {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['direct_mail_userfunc']['userFunc'][] = [
            'class' => \Causal\DirectMailUserfunc\Samples\TestList::class,
            'method' => 'myRecipientList',
            'label' => 'LLL:EXT:direct_mail_userfunc/Resources/Private/Language/locallang.xlf:userfunction.myRecipientList'
        ];

        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['direct_mail_userfunc']['userFunc'][] = [
            'class' => \Causal\DirectMailUserfunc\Samples\TestListExtjs::class,
            'method' => 'myRecipientList',
            'label' => 'LLL:EXT:direct_mail_userfunc/Resources/Private/Language/locallang.xlf:userfunction.myRecipientListExtJS'
        ];

        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['direct_mail_userfunc']['userFunc'][] = [
            'class' => \Causal\DirectMailUserfunc\Samples\TestListTca::class,
            'method' => 'myRecipientList',
            'label' => 'LLL:EXT:direct_mail_userfunc/Resources/Private/Language/locallang.xlf:userfunction.myRecipientListTca'
        ];
    }
}
