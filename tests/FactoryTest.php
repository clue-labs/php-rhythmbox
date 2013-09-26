<?php

use Clue\Basedir\Basedir;
use Clue\Rhythmbox\Factory;

class FactoryTest extends TestCase
{
    public function testConstructorDoesNotRequireArguments()
    {
        $factory = new Factory();
    }

    public function testCreateDatabase()
    {
        $factory = $this->createFactory();

        $db = $factory->createDatabase();

        $this->assertInstanceOf('Clue\Rhythmbox\Database\DatabaseInterface', $db);
    }

    public function testCreatePlaylists()
    {
        $factory = $this->createFactory();

        $playlists = $factory->createPlaylists();

        $this->assertInstanceOf('Clue\Rhythmbox\Playlists', $playlists);
    }

    public function testCreateLyricist()
    {
        $factory = $this->createFactory();

        $lyricist = $factory->createLyricist();

        $this->assertInstanceOf('Clue\Rhythmbox\Lyrics\Lyricist', $lyricist);
    }
}
