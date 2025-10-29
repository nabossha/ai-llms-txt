<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addTypoScript(
    'ai_llms_txt',
    'setup',
    '@import "EXT:ai_llms_txt/Configuration/TypoScript/setup.typoscript"'
);

ExtensionManagementUtility::addTypoScript(
    'ai_llms_txt',
    'setup',
    '@import "EXT:ai_llms_txt/Configuration/TypoScript/markdown.typoscript"'
);
