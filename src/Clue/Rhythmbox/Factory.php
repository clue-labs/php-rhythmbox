<?php

namespace Clue\Rhythmbox;

use Clue\Basedir\Basedir;
use Clue\Rhythmbox\Database;

class Factory
{
    private $basedir;

    public function __construct()
    {
        $this->basedir = new Basedir();
    }

    public function createDatabase()
    {
        return new Database($this->basedir->getDataHome() . 'rhythmbox/rhythmdb.xml');
    }
}
