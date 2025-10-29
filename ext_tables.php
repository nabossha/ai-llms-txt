<?php

declare(strict_types=1);

defined('TYPO3') or die();

// Register icon for backend module
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'llms-txt-module',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:llms_txt/Resources/Public/Icons/Extension.svg']
);
