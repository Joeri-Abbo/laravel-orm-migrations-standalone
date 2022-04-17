#!/usr/bin/env bash
if [ -z "$1" ]
then
    echo "Please provide a migration name"
    exit
fi
php vendor/bin/phinx create $1 -c config-phinx.php
