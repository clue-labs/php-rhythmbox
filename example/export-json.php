<?php

use Clue\Rhythmbox\Factory;

require __DIR__ . '/../vendor/autoload.php';

$factory = new Factory();

$database = $factory->createDatabase();

$data = array();
foreach ($database->getSongs() as $song) {
    $data[] = $song->getAttributes();
}

echo json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) . PHP_EOL;
