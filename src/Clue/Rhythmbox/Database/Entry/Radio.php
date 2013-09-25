<?php

namespace Clue\Rhythmbox\Database\Entry;

use Clue\Rhythmbox\Database\Entry\BaseEntry;

class Radio extends BaseEntry
{
    public function getType()
    {
        return 'iradio';
    }

    public function getTitle()
    {
        return $this->getAttribute('title');
    }

    public function getGenre()
    {
        return $this->getAttribute('genre');
    }

    public function getLocation()
    {
        return $this->getAttribute('location');
    }

    public function getRating()
    {
        return $this->getAttribute('rating');
    }

    public function getPlayCount()
    {
        return $this->getAttribute('play-count');
    }

    public function getLastPlayed()
    {
        return $this->getAttribute('last-played');
    }

    public function getBitrate()
    {
        return $this->getAttribute('bitrate');
    }

    public function getMediaType()
    {
        return $this->getAttribute('media-type');
    }
}
