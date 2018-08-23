<?php

$tempColumns = [
    'tx_directmailuserfunc_itemsprocfunc' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:direct_mail_userfunc/Resources/Private/Language/locallang_db.xlf:sys_dmail_group.tx_directmailuserfunc_itemsprocfunc',
        'config' => [
            'type' => 'input',
            'size' => '40',
            'eval' => 'required',
            'fieldControl' => [
                'checkControl' => [
                    'renderType' => 'checkUserfuncControl'
                ]
            ],
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
