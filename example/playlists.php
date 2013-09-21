<?php

use Clue\Rhythmbox\Factory;
use Clue\Rhythmbox\Playlist\AutomaticPlaylist;

require __DIR__ . '/../vendor/autoload.php';

$factory = new Factory();

$database = $factory->createDatabase();

$playlists = $factory->createPlaylists();

function sum($array, $key)
{
    $sum = 0;
    foreach ($array as $one) {
        $sum += isset($one[$key]) ? $one[$key] : 0;
    }
    return $sum;
}

foreach ($playlists->getPlaylists() as $playlist) {
    echo $playlist->getName() . PHP_EOL;
    if ($playlist instanceof AutomaticPlaylist) {
        if ($playlist->hasLimit()) {
            echo 'Limit: ' . $playlist->getLimitMax();
            $property = $playlist->getLimitProperty();
            if ($property !== null) {
                echo ' of ' . $property;
            }

            echo ' ordered by ' . $playlist->getSortKey();
            if ($playlist->getSortDirection()) {
                echo ' (reversed)';
            }
            echo PHP_EOL;
        } else {
            echo 'Limit: none' . PHP_EOL;
        }
    }

    $songs = $playlist->getSongsFromDatabase($database);
    echo 'Found ' . count($songs) .' song(s)' . PHP_EOL;
    echo 'Total of ' . sum($songs, 'file-size') . ' bytes' . PHP_EOL;
    echo 'Total of ' . sum($songs, 'duration') . ' seconds' . PHP_EOL;

    foreach ($songs as $song) {
        echo ' - ' . $song['location'] . PHP_EOL;
    }

    echo PHP_EOL;
}
