<?php

namespace Clue\Rhythmbox\Database;

class CachedDatabase extends BaseDatabase
{
    private $xml;
    private $all = null;

    public function __construct(XmlDatabase $database)
    {
        $this->xml = $database;
    }

    public function getAll()
    {
        if ($this->all === null) {
            // TODO: check cache
            $this->all = $this->xml->getAll();
        }

        return $this->all;
    }
}
