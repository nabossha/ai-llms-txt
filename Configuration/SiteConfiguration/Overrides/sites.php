<?php

/**
 * Add llms.txt configuration fields to site configuration
 */

// Add llmsTxtEnabled field
$GLOBALS['SiteConfiguration']['site']['columns']['llmsTxtEnabled'] = [
    'label' => 'LLL:EXT:llms_txt/Resources/Private/Language/locallang.xlf:site.llmsTxtEnabled',
    'description' => 'LLL:EXT:llms_txt/Resources/Private/Language/locallang.xlf:site.llmsTxtEnabled.description',
    'config' => [
        'type' => 'check',
        'renderType' => 'checkboxToggle',
        'default' => 1,
        'items' => [
            [
                'label' => '',
                'labelChecked' => 'Enabled',
                'labelUnchecked' => 'Disabled',
            ],
        ],
    ],
];

// Add llmsTxtTitle field
$GLOBALS['SiteConfiguration']['site']['columns']['llmsTxtTitle'] = [
    'label' => 'LLL:EXT:llms_txt/Resources/Private/Language/locallang.xlf:site.llmsTxtTitle',
    'description' => 'LLL:EXT:llms_txt/Resources/Private/Language/locallang.xlf:site.llmsTxtTitle.description',
    'config' => [
        'type' => 'input',
        'placeholder' => 'LLL:EXT:llms_txt/Resources/Private/Language/locallang.xlf:site.llmsTxtTitle.placeholder',
        'eval' => 'trim',
    ],
];

// Add llmsTxtDescription field
$GLOBALS['SiteConfiguration']['site']['columns']['llmsTxtDescription'] = [
    'label' => 'LLL:EXT:llms_txt/Resources/Private/Language/locallang.xlf:site.llmsTxtDescription',
    'description' => 'LLL:EXT:llms_txt/Resources/Private/Language/locallang.xlf:site.llmsTxtDescription.description',
    'config' => [
        'type' => 'text',
        'rows' => 3,
        'eval' => 'trim',
    ],
];

// Add llmsTxtAdditionalInfo field
$GLOBALS['SiteConfiguration']['site']['columns']['llmsTxtAdditionalInfo'] = [
    'label' => 'LLL:EXT:llms_txt/Resources/Private/Language/locallang.xlf:site.llmsTxtAdditionalInfo',
    'description' => 'LLL:EXT:llms_txt/Resources/Private/Language/locallang.xlf:site.llmsTxtAdditionalInfo.description',
    'config' => [
        'type' => 'text',
        'rows' => 10,
        'renderType' => 'codeEditor',
        'eval' => 'trim',
    ],
];

// Add llmsTxtContactEmail field
$GLOBALS['SiteConfiguration']['site']['columns']['llmsTxtContactEmail'] = [
    'label' => 'LLL:EXT:llms_txt/Resources/Private/Language/locallang.xlf:site.llmsTxtContactEmail',
    'description' => 'LLL:EXT:llms_txt/Resources/Private/Language/locallang.xlf:site.llmsTxtContactEmail.description',
    'config' => [
        'type' => 'input',
        'eval' => 'trim,email',
        'placeholder' => 'contact@example.com',
    ],
];

// Add llmsTxtKeywords field
$GLOBALS['SiteConfiguration']['site']['columns']['llmsTxtKeywords'] = [
    'label' => 'LLL:EXT:llms_txt/Resources/Private/Language/locallang.xlf:site.llmsTxtKeywords',
    'description' => 'LLL:EXT:llms_txt/Resources/Private/Language/locallang.xlf:site.llmsTxtKeywords.description',
    'config' => [
        'type' => 'input',
        'eval' => 'trim',
        'placeholder' => 'LLL:EXT:llms_txt/Resources/Private/Language/locallang.xlf:site.llmsTxtKeywords.placeholder',
    ],
];

// Add llmsTxtMaxDepth field
$GLOBALS['SiteConfiguration']['site']['columns']['llmsTxtMaxDepth'] = [
    'label' => 'LLL:EXT:llms_txt/Resources/Private/Language/locallang.xlf:site.llmsTxtMaxDepth',
    'description' => 'LLL:EXT:llms_txt/Resources/Private/Language/locallang.xlf:site.llmsTxtMaxDepth.description',
    'config' => [
        'type' => 'number',
        'default' => 2,
        'range' => [
            'lower' => 1,
            'upper' => 5,
        ],
    ],
];

// Add new tab and fields to showitem
if (!isset($GLOBALS['SiteConfiguration']['site']['types']['0']['showitem'])) {
    $GLOBALS['SiteConfiguration']['site']['types']['0']['showitem'] = '';
}

$GLOBALS['SiteConfiguration']['site']['types']['0']['showitem'] .= ',
    --div--;LLL:EXT:llms_txt/Resources/Private/Language/locallang.xlf:site.tab.llmstxt,
        llmsTxtEnabled,
        llmsTxtTitle,
        llmsTxtDescription,
        llmsTxtAdditionalInfo,
        llmsTxtContactEmail,
        llmsTxtKeywords,
        llmsTxtMaxDepth
';
