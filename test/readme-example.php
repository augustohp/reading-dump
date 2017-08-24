<?php

require __DIR__ . '/bootstrap.php';

$exitCode = 255;
$output = null;

$articleUrl =  "https://medium.com/computeiros/shell-sorteando-coisas-como-um-dev-d63bb6e85f3f";
$command = "php reading-dump.php pocket-save --url '${articleUrl}'";

exec($command, $output, $exitCode);
if ($exitCode !== 0) {
    echo 'Problem saving article to tag.';
    var_dump($exitCode, $output);
    return false; // fails test
}

$command = "php reading-dump.php pocket-retrieve | php reading-dump.php filter-reading-time --less-than-minutes 5 | php reading-dump.php pocket-tag";
exec($command, $output, $exitCode);
var_dump($command, $exitCode, $output);

return $exitCode === 0;
