<?php

namespace Clue\Rhythmbox\Database\Entry;

use Clue\Rhythmbox\Database\Entry\BaseEntry;

class Ignore extends BaseEntry
{
    public function getType()
    {
        return 'ignore';
    }

    public function getLocation()
    {
        return $this->getAttribute('location');
    }

    public function getMtime()
    {
        return $this->getAttribute('mtime');
    }

    public function getMediaType()
    {
        return $this->getAttribute('media-type');
    }
}
