#!/bin/bash

# Filters input file looking for mail paterns
# and ignore whatever matches terms in ignoreFile.
#
# Useful combined with a thunderbird import-export NG plugin
# that is able to export a list of mails into a single txt file.

# Check if the required first argument is provided
if [ $# -lt 1 ]; then
    echo "Usage: $0 <input file> [<ignore file>]"
    exit 1
fi

# Save arguments in variables for clarity
input="$1"
ignoreFile="$2"

# Check if the input file exists and is readable
if [ ! -r "$input" ]; then
    echo "Input file \"$input\" does not exist or is not readable"
    exit 2
fi

# Read the contents of the ignore file into a bash variable
if [ -n "$ignoreFile" ] && [ -r "$ignoreFile" ]; then
    ignoreList="$(cat "$ignoreFile")"
fi


# Filter the input file for email addresses and exclude any that appear in the ignore file
grep -o -i -E '\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b' "$input" \
    | grep -v -i -F -x -f <(echo "$ignoreList") \
    | sort -u

# Exit with success code
exit 0

