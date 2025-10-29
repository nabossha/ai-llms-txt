#!/usr/bin/env php
<?php

declare(strict_types=1);

/**
 * This file is part of the LLMS TXT extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Validate reStructuredText files for basic syntax issues
 */

$rstFiles = [];
$directoryIterator = new RecursiveDirectoryIterator('./Documentation');
$recursiveIterator = new RecursiveIteratorIterator($directoryIterator);

foreach ($recursiveIterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'rst') {
        $rstFiles[] = $file->getPathname();
    }
}

if (empty($rstFiles)) {
    echo "No .rst files found in Documentation/\n";
    exit(0);
}

$errors = 0;

foreach ($rstFiles as $file) {
    $content = file_get_contents($file);
    if ($content === false) {
        echo "ERROR: Could not read file: $file\n";
        $errors++;
        continue;
    }

    $lines = explode("\n", $content);
    $lineNumber = 0;

    foreach ($lines as $line) {
        $lineNumber++;

        // Check for tabs (should use spaces)
        if (strpos($line, "\t") !== false) {
            echo "ERROR: Tab character found in $file:$lineNumber\n";
            $errors++;
        }

        // Check for trailing whitespace
        if (rtrim($line) !== $line) {
            echo "WARNING: Trailing whitespace in $file:$lineNumber\n";
        }
    }

    // Check for basic RST syntax issues
    if (preg_match('/^=+$/', $lines[0] ?? '') && !preg_match('/^=+$/', $lines[2] ?? '')) {
        echo "WARNING: Title underline might be mismatched in $file\n";
    }
}

if ($errors > 0) {
    echo "\nFound $errors errors in RST files.\n";
    exit(1);
} else {
    echo "All RST files validated successfully.\n";
    exit(0);
}