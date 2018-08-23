<?php
defined('TYPO3_MODE') || die();

$boot = function ($_EXTKEY) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1535016737] = [
        'nodeName' => 'checkUserfuncControl',
        'priority' => 30,
        'class' => \Causal\DirectMailUserfunc\FormEngine\FieldControl\CheckUserfuncControl::class
    ];
};

$boot($_EXTKEY);
unset($boot);
