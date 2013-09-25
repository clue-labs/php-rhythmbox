<?php

use Clue\Rhythmbox\Factory;
use Clue\Rhythmbox\Playlist\AutomaticPlaylist;
use Clue\Rhythmbox\Database\Entry\Song;

require __DIR__ . '/../vendor/autoload.php';

$factory = new Factory();

$lyricist = $factory->createLyricist();

$database = $factory->createDatabase();

foreach ($database->getSongs() as $song) {
    /* @var $song Song */
    if ($lyricist->hasLyricsForSong($song)) {
        $lyrics = trim($lyricist->getLyricsForSong($song));
        $lyrics = mb_strimwidth($lyrics, 0, 100, '…', 'utf-8');

        echo <<<EOF
{$song->getArtist()} - {$song->getTitle()}
------------------------------------------
$lyrics



EOF;
    }
}
