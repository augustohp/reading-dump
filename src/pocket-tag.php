<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/functions.php';

use Respect\Validation\Validator as v;
use tflori\Getopt;

function mapLineToArguments($line)
{
    $lineColumns = explode(' ', $line);
    if (count($lineColumns) <= 1) {
        return [];
    }

    if (count($lineColumns) < 3) {
        echo 'Error: Needed 3 columns of information.' . PHP_EOL . $line;
        exit(2);
    }

    $tag = 'reading-dump';
    list($articleId, $articleCreatedAt, $wordCount) = $lineColumns;

    return [$articleId, $articleCreatedAt, $wordCount, $tag];
}

function mapCommandCallToArguments($argv)
{
    echo 'Not available';
    exit(2);
}

function actionPerLine(Pocket $api, array $arguments)
{
    list($articleId, $articleCreatedAt, $wordCount, $tagName) = $arguments;
    return pocketTag($api, $articleId, [$tagName]);
}

