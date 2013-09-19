<?php

use Clue\Rhythmbox\Factory;

require __DIR__ . '/../vendor/autoload.php';

$factory = new Factory();

$database = $factory->createDatabase();

echo json_encode($database->getSongs(), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) . PHP_EOL;
