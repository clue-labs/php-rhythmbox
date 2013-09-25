<?php

namespace Clue\Rhythmbox\Lyrics;

use Clue\Rhythmbox\Database\Entry\Song;

class Lyricist
{
    private $basepath;

    public function __construct($basepath)
    {
        $this->basepath = rtrim($basepath, '/') . '/';
    }

    public function getLyricsForSong(Song $song)
    {
        $path = $this->getPathForSong($song);

        if (!is_readable($this->basepath . $path)) {
            throw new \RuntimeException('No lyrics for "' . $path . '" found');
        }

        return file_get_contents($this->basepath . $path);
    }

    public function hasLyricsForSong(Song $song)
    {
        return is_readable($this->basepath . $this->getPathForSong($song));
    }

    private function getPathForSong(Song $song)
    {
        // TODO: clean up special chars?
        $path = mb_strtolower($song->getArtist() . '/' . $song->getTitle() . '.lyric', 'utf-8');

        return $path;
    }
}
