<?php

use Clue\Basedir\Basedir;
use Clue\Rhythmbox\Factory;

require __DIR__ . '/../vendor/autoload.php';

class TestCase extends PHPUnit_Framework_TestCase
{
    protected function createFactory()
    {
        $basedir = new Basedir();

        return new Factory($basedir);
    }

    protected function createDatabase()
    {
        return $this->createFactory()->createDatabase();
    }
}
