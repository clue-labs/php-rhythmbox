<?php

namespace Clue\Rhythmbox\Playlist;

use Clue\Rhythmbox\Database;

class QueuePlaylist extends PlaylistBase
{
    public function getSongsFromDatabase(Database $database)
    {
        if (!$this->xml->location) {
            // empty static playlist
            return array();
        }

        $locations = array();

        foreach ($this->xml->location as $location) {
            $locations[] = (string)$location;
        }

        return array_values(array_filter($database->getSongs(), function ($song) use ($locations) {
            return in_array($song['location'], $locations);
        }));
    }
}
