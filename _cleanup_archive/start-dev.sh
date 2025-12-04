#!/bin/bash

# Workaround for Turbopack panic with Cyrillic characters in path
# This script creates a symlink with ASCII name and runs dev server from there

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
SYMLINK_PATH="/tmp/inmunoflam-dev"

# Remove old symlink if exists
if [ -L "$SYMLINK_PATH" ]; then
    rm "$SYMLINK_PATH"
fi

# Create new symlink
ln -s "$SCRIPT_DIR" "$SYMLINK_PATH"

# Change to symlink directory and run dev server
cd "$SYMLINK_PATH"
npm run dev
