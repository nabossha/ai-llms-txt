<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'LLMS TXT Generator',
    'description' => 'TYPO3 extension for generating llms.txt links according to llmstxt.org specification to control Large Language Model crawling policies.',
    'category' => 'be',
    'author' => 'web-vision GmbH',
    'author_email' => 'hello@web-vision.de',
    'state' => 'alpha',
    'version' => '0.1.1',
    'constraints' => [
        'depends' => [
            'typo3' => '13.0.0-13.99.99',
            'backend' => '13.0.0-13.99.99',
            'extbase' => '13.0.0-13.99.99',
            'fluid' => '13.0.0-13.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
