<?php

declare(strict_types=1);

defined('TYPO3') or die();

use FGTCLB\LlmsTxt\Task\LlmTxtSchedulerTask;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

// Register scheduler task
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][LlmTxtSchedulerTask::class] = [
    'extension' => 'llms_txt',
    'title' => 'LLL:EXT:llms_txt/Resources/Private/Language/locallang.xlf:scheduler.task.title',
    'description' => 'LLL:EXT:llms_txt/Resources/Private/Language/locallang.xlf:scheduler.task.description',
];

ExtensionManagementUtility::addTypoScript(
    'llms_txt',
    'setup',
    '@import "EXT:llms_txt/Configuration/TypoScript/setup.typoscript"'
);
