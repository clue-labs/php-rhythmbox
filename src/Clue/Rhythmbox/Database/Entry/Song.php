<?php

namespace Clue\Rhythmbox\Database\Entry;

use Clue\Rhythmbox\Database\Entry\BaseEntry;

class Song extends BaseEntry
{
    public function getType()
    {
        return 'song';
    }

    public function getTitle()
    {
        return $this->getAttribute('title');
    }

    public function getGenre()
    {
        return $this->getAttribute('genre');
    }

    public function getArtist()
    {
        return $this->getAttribute('artist');
    }

    public function getAlbum()
    {
        return $this->getAttribute('album');
    }

    public function getTrackNumber()
    {
        return $this->getAttribute('track-number');
    }

    public function getDuration()
    {
        return $this->getAttribute('duration');
    }

    public function getFileSize()
    {
        return $this->getAttribute('file-size');
    }

    public function getLocation()
    {
        return $this->getAttribute('location');
    }

    public function getMountpoint()
    {
        return $this->getAttribute('mountpoint');
    }

    public function getMtime()
    {
        return $this->getAttribute('mtime');
    }

    public function getFirstSeen()
    {
        return $this->getAttribute('first-seen');
    }

    public function getLastSeen()
    {
        return $this->getAttribute('last-seen');
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

    public function getDate()
    {
        return $this->getAttribute('date');
    }

    public function getMediaType()
    {
        return $this->getAttribute('media-type');
    }

    protected static $ints = array(
        'track-number',
        'duration',
        'file-size',
        'mtime',
        'first-seen',
        'last-seen',
        'rating',
        'play-count',
        'last-played',
        'bitrate',
        'date',
    );

    /*
    {
        "type": "song",
        "title": "You're Not The Only Thing Getting Wasted",
        "genre": "Unbekannt",
        "artist": "Don't Wait Up",
        "album": "Unbekannt",
        "track-number": "100",
        "duration": "179",
        "file-size": "2869319",
        "location": "file:///home/me/streamripped/Don't%20Wait%20Up%20-%20You're%20Not%20The%20Only%20Thing%20Getting%20Wasted.mp3",
        "mountpoint": "file:///home/me/key-private",
        "mtime": "1328179105",
        "first-seen": "1379616585",
        "last-seen": "1380102409",
        "rating": "1",
        "play-count": "1",
        "last-played": "1379764319",
        "bitrate": "127",
        "date": "0",
        "media-type": "audio/mpeg"
    },
    */
}
