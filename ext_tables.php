<?php
defined('TYPO3_MODE') || die();

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
