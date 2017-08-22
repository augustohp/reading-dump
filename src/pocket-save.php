<?php

require __DIR__ . '/../vendor/autoload.php';

use Respect\Validation\Validator as v;
use tflori\Getopt;

function saveUrl($pocketApi, $url)
{
    return $pocketApi->add([
        "url" => $url,
        "title" => "A test article for github.com/augustohp/reading-dump",
        "tags" => "test"
    ]);
}

$isPipedExecution = false === posix_isatty(STDIN);
if ($isPipedExecution) {
    while(!feof(STDIN)) {
        $line = fgets(STDIN);
        $saneLine = trim($line);
        $lineColumns = explode(' ', $saneLine);
        if (count($lineColumns) < 1) {
            continue;
        }

        list($urlToSave) = $lineColumns;
        saveUrl($pocketApi, $urlToSave);
        echo line;
    }
} else {
    $cli = new Getopt\Getopt([
        (new Getopt\Option('u', 'url', Getopt\Getopt::REQUIRED_ARGUMENT))
    ]);
    $cli->parse($argv);

    try {
        $urlToSave = $cli->getOption('url');
        v::url()->assert($urlToSave);
        saveUrl($pocketApi, $urlToSave);
        exit(0);
    } catch (ValidationException $e) {
        echo $e->getFullMessage() . PHP_EOL;
    } catch (PocketException $e) {
        echo $e->getMessage() . PHP_EOL;
    }
    exit(2);
}
