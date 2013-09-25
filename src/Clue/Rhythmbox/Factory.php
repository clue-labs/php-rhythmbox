<?php

namespace Clue\Rhythmbox;

use Clue\Basedir\Basedir;
use Clue\Rhythmbox\Database\XmlDatabase;
use Clue\Rhythmbox\Database\CachedDatabase;
use Clue\Rhythmbox\Lyrics\Lyricist;

class Factory
{
    private $basedir;

    public function __construct()
    {
        $this->basedir = new Basedir();
    }

    public function createPlaylists()
    {
        return new Playlists($this->basedir->getDataHome() . 'rhythmbox/playlists.xml');
    }

    public function createDatabase()
    {
        return new CachedDatabase(new XmlDatabase($this->basedir->getDataHome() . 'rhythmbox/rhythmdb.xml'));
    }

    public function createLyricist()
    {
        return new Lyricist($this->basedir->getCacheHome() . 'rhythmbox/lyrics/');
    }
}
