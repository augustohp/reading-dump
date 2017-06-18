<?php

require __DIR__ . '/../vendor/autoload.php';

use Respect\Validation\Validator as v;
use tflori\Getopt;

$cli = new Getopt\Getopt([
    (new Getopt\Option('l', 'limit', Getopt\Getopt::REQUIRED_ARGUMENT))->setDefaultValue(10),
    (new Getopt\Option('s', 'since', Getopt\Getopt::REQUIRED_ARGUMENT))->setDefaultValue(0),
    (new Getopt\Option('o', 'sort', Getopt\Getopt::REQUIRED_ARGUMENT))->setDefaultValue('oldest'),
]);
$cli->parse($argv);

v::intVal()->min(1)->max(100)->setName('limit')->assert($cli->getOption('limit'));
v::optional(v::date('U'))->setName('since')->assert($cli->getOption('since'));
v::alnum()->in(['newest', 'oldest', 'title', 'site'])->setName('sort')->assert($cli->getOption('sort'));

$searchOptions = [
    'state' => 'unread',
    'sort' => $cli['sort'],
    'detailType' => 'complete',
    'favorite' => 0,
    'count' => $cli->getOption('limit'),
    'contentType' => 'article',
    'since' => $cli->getOption('since')
];
$items = $pocketApi->retrieve($searchOptions);

if (isset($items['error']) && count($items['error'])) {
    var_dump($items['error']);
    echo "Unknown error retrieving articles from Pocket." . PHP_EOL;
    exit(2);
}

foreach ($items['list'] as $item) {
    $alreadyTagged = isset($item['tags']) && isset($item['tags']['reading-dump']);
    if ($alreadyTagged) {
        continue;
    }
    $line = [
        $item['item_id'],
        $item['time_added'],
        $item['word_count'],
        'https://getpocket.com/a/read/' . $item['item_id'],
        PHP_EOL
    ];
    echo implode(' ', $line);
}
