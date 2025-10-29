<?php

declare(strict_types=1);

defined('TYPO3') or die();

$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'llms-txt-module',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:ai_llms_txt/Resources/Public/Icons/Extension.svg']
);
