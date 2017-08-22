<?php

require __DIR__ . '/../vendor/autoload.php';

use Respect\Validation\Validator as v;
use tflori\Getopt;

function mapLineToArguments($line)
{
    $lineColumns = explode(' ', $line);
    if (count($lineColumns) < 1) {
        continue;
    }

    list($urlToSave) = $lineColumns;

    return [$urlToSave];
}

function mapCommandCallToArguments($argv)
{
    $cli = new Getopt\Getopt([
        (new Getopt\Option('u', 'url', Getopt\Getopt::REQUIRED_ARGUMENT))
    ]);
    $cli->parse($argv);

    try {
        $urlToSave = $cli->getOption('url');
        v::url()->assert($urlToSave);

        return [$urlToSave];
    } catch (ValidationException $e) {
        echo $e->getFullMessage() . PHP_EOL;
    } catch (PocketException $e) {
        echo $e->getMessage() . PHP_EOL;
    }
    exit(2);
}

function actionPerLine(Pocket $api, array $arguments)
{
    list($url) = $arguments;
    return $api->add([
        "url" => $url,
        "title" => "A test article for github.com/augustohp/reading-dump",
        "tags" => "test"
    ]);
}

