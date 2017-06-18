<?php

require __DIR__ . '/../vendor/autoload.php';

use Respect\Validation\Validator as v;
use tflori\Getopt;

define('WORDS_PER_MINUTE', 270);
$cli = new Getopt\Getopt([
    (new Getopt\Option('l', 'less-than-minutes', Getopt\Getopt::REQUIRED_ARGUMENT))->setDefaultValue(5),
]);
$cli->parse($argv);

try {
    v::intVal()->min(1)->max(60)->setName('less-than-minutes')->assert($cli->getOption('less-than-minutes'));
} catch (Exception $e) {
    echo $e->getFullMessage() . PHP_EOL;
    exit(2);
}

while(!feof(STDIN)) {
    $line = fgets(STDIN);
    $saneLine = trim($line);
    $lineColumns = explode(' ', $saneLine);
    if (count($lineColumns) < 3) {
        continue;
    }
    list($articleId, $articleCreatedAt, $wordCount) = $lineColumns;
    $estimateReadTime = ceil($wordCount / WORDS_PER_MINUTE);
    if ($estimateReadTime < $cli->getOption('less-than-minutes')) {
        echo $line;
    }
}

