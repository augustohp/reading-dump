<?php

$total = $success = $failure = 0;
$executeTest = function($file) use (&$total, &$success, &$failure)
{
    $result = require $file;
    $total++;
    if ($result === 0) {
        echo '.';
        $success++;
    } else {
        echo 'E';
        $failure++;
    }
};

echo 'Reding Dump Test Suite' . PHP_EOL . PHP_EOL ;

$starTime = microtime(true);

foreach (glob('test/*.php') as $file) {
    if ($file == 'test/bootstrap.php') {
        continue;
    }

    $executeTest($file);
}
$endTime = microtime(true);
$totalTime = $endTime - $starTime ;
echo PHP_EOL . PHP_EOL ;
echo 'Executed in ' . number_format($totalTime, 6) . ' seconds.' . PHP_EOL;
echo sprintf(
    '%s total tests, with %s successes and %s failures.' . PHP_EOL,
    $total,
    $success,
    $failure
);
