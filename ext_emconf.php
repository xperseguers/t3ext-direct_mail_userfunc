<?php

// -------------------------------------------------------------------------
// Extension Manager/Repository config file for ext: "direct_mail_userfunc"
// -------------------------------------------------------------------------

$EM_CONF[$_EXTKEY] = [
    'title' => 'External Providers for Direct Mail',
    'description' => 'Adds support for external providers to Direct Mail. This extension extends the types of recipient lists handled by Direct Mail with an entry for parameterized custom lists. These custom lists are prepared by user functions and may easily reuse your own business logic.',
    'category' => 'module',
    'author' => 'Xavier Perseguers',
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
    'version' => '2.0.0-dev',
    'constraints' => [
        'depends' => [
            'php' => '7.2.0-7.2.99',
            'typo3' => '8.7.0-8.7.99',
            'direct_mail' => '5.2.0-5.2.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    '_md5_values_when_last_written' => '',
    'suggests' => [],
    'autoload' => [
        'psr-4' => ['Causal\\DirectMailUserfunc\\' => 'Classes']
    ],
];
