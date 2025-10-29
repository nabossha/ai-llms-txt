#!/bin/bash

#
# Check UTF-8 files for BOM
#
# This script checks for UTF-8 Byte Order Mark in files that should not have one.
# A BOM can cause issues in PHP and web applications.
#

echo "Checking for UTF-8 BOM in files..."

FOUND_BOM=0

# Check PHP files
for FILE in $(find . -name "*.php" ! -path "./.Build/*" ! -path "./vendor/*" ! -path "./.cache/*"); do
    if [ "$(head -c3 "$FILE")" == $'\xef\xbb\xbf' ]; then
        echo "UTF-8 BOM found in: $FILE"
        FOUND_BOM=1
    fi
done

# Check other text files
for FILE in $(find . -name "*.xml" -o -name "*.yaml" -o -name "*.yml" -o -name "*.js" -o -name "*.css" -o -name "*.ts" -o -name "*.json" ! -path "./.Build/*" ! -path "./vendor/*" ! -path "./.cache/*" ! -path "./node_modules/*"); do
    if [ "$(head -c3 "$FILE")" == $'\xef\xbb\xbf' ]; then
        echo "UTF-8 BOM found in: $FILE"
        FOUND_BOM=1
    fi
done

if [ $FOUND_BOM -eq 1 ]; then
    echo "ERROR: Found files with UTF-8 BOM. Please remove the BOM from these files."
    exit 1
else
    echo "No UTF-8 BOM found in files."
    exit 0
fi