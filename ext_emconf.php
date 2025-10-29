<?php

declare(strict_types=1);

$EM_CONF['llms_txt'] = [
    'title' => 'LLMS TXT Generator',
    'description' => 'TYPO3 extension for generating .well-known/llm.txt files according to llmstxt.org specification to control Large Language Model crawling policies.',
    'category' => 'be',
    'author' => 'FGTCLB',
    'author_email' => '',
    'state' => 'stable',
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.0.0-13.99.99',
            'backend' => '13.0.0-13.99.99',
            'extbase' => '13.0.0-13.99.99',
            'fluid' => '13.0.0-13.99.99',
            'scheduler' => '13.0.0-13.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
