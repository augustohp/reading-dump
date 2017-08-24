<?php

require __DIR__ . '/bootstrap.php';

$exitCode = 255;
$output = null;

$articleUrl =  "https://medium.com/computeiros/shell-sorteando-coisas-como-um-dev-d63bb6e85f3f";
$command = "php reading-dump.php pocket-save";

exec($command, $output, $exitCode);
var_dump($exitCode, $output);

return $exitCode !== 0;
