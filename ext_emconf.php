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
    'state' => 'stable',
    'version' => '2.3.0',
    'constraints' => [
        'depends' => [
            'php' => '7.4.0-8.3.99',
            'typo3' => '10.4.0-11.5.99',
            'direct_mail' => '7.0.0-9.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => ['Causal\\DirectMailUserfunc\\' => 'Classes']
    ],
];
