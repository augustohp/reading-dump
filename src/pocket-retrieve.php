<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/functions.php';

use Respect\Validation\Validator as v;
use tflori\Getopt;

function mapLineToArguments($line)
{
    echo 'Not available';
    exit(2);
}

function mapCommandCallToArguments($argv)
{
    $cli = new Getopt\Getopt([
        (new Getopt\Option('l', 'limit', Getopt\Getopt::REQUIRED_ARGUMENT))->setDefaultValue(10),
        (new Getopt\Option('s', 'since', Getopt\Getopt::REQUIRED_ARGUMENT))->setDefaultValue(0),
        (new Getopt\Option('o', 'sort', Getopt\Getopt::REQUIRED_ARGUMENT))->setDefaultValue('oldest'),
    ]);
    $cli->parse($argv);

    try {
        v::intVal()->min(1)->max(100)->setName('limit')->assert($cli->getOption('limit'));
        v::optional(v::date('U'))->setName('since')->assert($cli->getOption('since'));
        v::alnum()->in(['newest', 'oldest', 'title', 'site'])->setName('sort')->assert($cli->getOption('sort'));

        return [$cli->getOption('since'), $cli->getOption('sort'), $cli->getOption('since')];
    } catch (ValidationException $e) {
        echo $e->getFullMessage() . PHP_EOL;
    } catch (PocketException $e) {
        echo $e->getMessage() . PHP_EOL;
    }
    exit(2);
}

function actionPerLine(Pocket $api, array $arguments)
{
    list($since, $sort, $limit) = $arguments;
    $searchOptions = [
        'state' => 'unread',
        'sort' => $sort,
        'detailType' => 'complete',
        'favorite' => 0,
        'count' => $limit,
        'contentType' => 'article',
        'since' => $since
    ];
    $items = pocketSearch($api, $searchOptions);

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
}
