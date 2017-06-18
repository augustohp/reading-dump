<?php

$app = APP_BIN;
echo <<<EOT
Usage: ${app} <command> [options]

Available commands are:
    pocket-retrieve
    pocket-tag
    filter-read-time
    help

EOT;

exit(1);
