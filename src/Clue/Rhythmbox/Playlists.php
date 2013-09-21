<?php

namespace Clue\Rhythmbox;

use SimpleXmlElement;
use Clue\Rhythmbox\Playlist\StaticPlaylist;
use Clue\Rhythmbox\Playlist\AutomaticPlaylist;
use Clue\Rhythmbox\Playlist\QueuePlaylist;

class Playlists
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function getPlaylists()
    {
        $xml = $this->getXml();
        $all = array();

        foreach ($xml->playlist as $playlist) {
            /* @var $playlist SimpleXmlElement */

            $type = (string)$playlist['type'];
            if ($type === 'static') {
                $all[] = new StaticPlaylist($playlist);
            } elseif ($type === 'automatic') {
                $all[] = new AutomaticPlaylist($playlist);
            } elseif ($type === 'queue') {
                $all[] = new QueuePlaylist($playlist);
            } else {
                throw new \RuntimeException();
            }
        }

        return $all;
    }

    public function getPlaylist($name)
    {
        foreach ($this->getPlaylists() as $playlist) {
            if ($playlist->getName() === $name) {
                return $playlist;
            }
        }

        throw new \OutOfBoundsException('Playlist with given name does not exist');
    }

    private function getXml()
    {
        return new \SimpleXMLElement(file_get_contents($this->path));
    }
}
