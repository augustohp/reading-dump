<?php

require __DIR__ . '/bootstrap.php';

$exitCode = 255;
$output = null;

$command = "php reading-dump.php pocket-retrieve | php reading-dump.php pocket-tag";

exec($command, $output, $exitCode);
var_dump($exitCode, $output);

return $exitCode === 0;
