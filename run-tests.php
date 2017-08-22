<?php

$total = $success = $failure = 0;
$executeTest = function($file) use (&$total, &$success, &$failure)
{
    ob_start();
    $result = require $file;
    $testOutput = ob_get_clean();

    $total++;
    if ($result === 0) {
        echo "Test '$file' successfull." . PHP_EOL;
        $success++;
    } else {
        echo PHP_EOL . 'Problem on: ' . $file . PHP_EOL;
        echo str_repeat('-', 80) . PHP_EOL;
        echo $testOutput . PHP_EOL;
        echo str_repeat('-', 80) . PHP_EOL;
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
