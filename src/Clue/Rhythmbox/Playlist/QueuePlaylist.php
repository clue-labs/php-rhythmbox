<?php

namespace Clue\Rhythmbox\Playlist;

use Clue\Rhythmbox\Database\DatabaseInterface;

class QueuePlaylist extends PlaylistBase
{
    public function getSongsFromDatabase(DatabaseInterface $database)
    {
        if (!$this->xml->location) {
            // empty static playlist
            return array();
        }

        $locations = array();

        foreach ($this->xml->location as $location) {
            $locations[] = (string)$location;
        }

        return array_values(array_filter($database->getSongs(), function (Song $song) use ($locations) {
            return in_array($song->getLocation(), $locations);
        }));
    }
}
