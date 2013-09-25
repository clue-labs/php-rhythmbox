<?php

namespace Clue\Rhythmbox\Database;

use Clue\Rhythmbox\Database\DatabaseInterface;
use Clue\Rhythmbox\Database\Entry\EntryInterface;

abstract class BaseDatabase implements DatabaseInterface
{
    public function getSongs()
    {
        return $this->getAllOfType('song');
    }

    public function getRadios()
    {
        return $this->getAllOfType('iradio');
    }

    private function getAllOfType($type)
    {
        return array_values(array_filter($this->getAll(), function (EntryInterface $one) use ($type) {
            return ($one->getType() === $type);
        }));
    }
}
