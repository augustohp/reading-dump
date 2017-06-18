<?php

require __DIR__ . '/../vendor/autoload.php';

use Respect\Validation\Validator as v;
use tflori\Getopt;

$cli = new Getopt\Getopt([
    (new Getopt\Option('t', 'tag', Getopt\Getopt::REQUIRED_ARGUMENT))->setDefaultValue('reading-dump'),
]);
$cli->parse($argv);

try {
    $tagName = $cli->getOption('tag');
    v::alnum('-')->length(3, 50)->setName('tag')->assert($tagName);
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
    $pocketApi->send([
        [
            "item_id" => $articleId,
            "action" => "tags_add",
            "tags" => $tagName
        ]
    ]);

    echo $line;
}

