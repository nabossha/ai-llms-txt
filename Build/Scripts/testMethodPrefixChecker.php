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
 * Check that test methods do not start with "test" prefix
 * 
 * Modern PHPUnit uses the @test annotation or Test suffix instead of test prefix
 */

$testFiles = [];
$directoryIterator = new RecursiveDirectoryIterator('./Tests');
$recursiveIterator = new RecursiveIteratorIterator($directoryIterator);

foreach ($recursiveIterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $testFiles[] = $file->getPathname();
    }
}

if (empty($testFiles)) {
    echo "No test files found in Tests/\n";
    exit(0);
}

$errors = 0;

foreach ($testFiles as $file) {
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

        // Check for methods starting with "test" but not "Test" (case sensitive)
        if (preg_match('/^\s*public\s+function\s+test[a-z]/i', $line)) {
            echo "ERROR: Test method should not start with 'test' prefix in $file:$lineNumber\n";
            echo "       Use @test annotation or 'Test' suffix instead: $line\n";
            $errors++;
        }
    }
}

if ($errors > 0) {
    echo "\nFound $errors test methods with incorrect naming.\n";
    echo "Use @test annotation or 'Test' suffix for test methods instead of 'test' prefix.\n";
    exit(1);
} else {
    echo "All test method names are correct.\n";
    exit(0);
}