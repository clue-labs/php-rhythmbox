<?php

namespace Clue\Rhythmbox\Database;

interface DatabaseInterface
{
    public function getSongs();

    public function getRadios();

    public function getAll();
}
