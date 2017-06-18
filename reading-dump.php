<?php

ini_set('display_errors', true);
error_reporting(-1);
require __DIR__ . '/vendor/autoload.php';

if (php_sapi_name() != "cli") {
    echo "Program must be executed on command line." . PHP_EOL;
    exit(2);
}

define('APP_BIN', $argv[0]);
// Defaults to "help" command
if ($argc <= 1) {
    $argv[] = "help";
    $argc++;
}

$command = $argv[1];
$sanitizedCommand = str_replace(['/', '\\', '_', '.'], '', strtolower($command));
$scriptToRequire = __DIR__ . "/src/${sanitizedCommand}.php";
if (false === file_exists($scriptToRequire)) {
    echo "Command '${sanitizedCommand}' unknown." . PHP_EOL;
    exit(2);
}

define('APP_ACCESS_TOKEN', getenv('POCKET_APP_ACCESS_TOKEN') ?: '');
define('APP_CONSUMER_KEY', getenv('POCKET_APP_CONSUMER_KEY') ?: '');
define('APP_PROGRAM', $sanitizedCommand);
if (empty(APP_ACCESS_TOKEN) || empty(APP_CONSUMER_KEY)) {
    throw new \UnexpectedValueException(
        '"POCKET_APP_ACCESS_TOKEN" or "POCKET_APP_CONSUMER_KEY" environment variables empty.'
    );
}

unset($command, $sanitizedCommand);
$pocketApi = new Pocket([
    'consumerKey' => APP_CONSUMER_KEY,
    'accessToken' => APP_ACCESS_TOKEN,
    'debug' => false
]);
require $scriptToRequire;
echo PHP_EOL;
exit(0);
