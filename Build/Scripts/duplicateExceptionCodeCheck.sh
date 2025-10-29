#!/bin/bash

#
# Check for duplicate exception codes in PHP files
#
# Exception codes should be unique within the extension to help with debugging
#

echo "Checking for duplicate exception codes..."

TEMP_FILE=$(mktemp)
FOUND_DUPLICATES=0

# Extract exception codes from PHP files
find . -name "*.php" ! -path "./.Build/*" ! -path "./vendor/*" ! -path "./.cache/*" -exec grep -n "throw new.*Exception.*[0-9]\+)" {} + | \
grep -o '[0-9]\{10,\}' | sort > "$TEMP_FILE"

# Check for duplicates
DUPLICATES=$(uniq -d "$TEMP_FILE")

if [ -n "$DUPLICATES" ]; then
    echo "ERROR: Found duplicate exception codes:"
    for CODE in $DUPLICATES; do
        echo "Code $CODE found in:"
        find . -name "*.php" ! -path "./.Build/*" ! -path "./vendor/*" ! -path "./.cache/*" -exec grep -l "throw new.*Exception.*$CODE)" {} +
        echo
    done
    FOUND_DUPLICATES=1
fi

rm "$TEMP_FILE"

if [ $FOUND_DUPLICATES -eq 1 ]; then
    echo "Please use unique exception codes."
    exit 1
else
    echo "No duplicate exception codes found."
    exit 0
fi