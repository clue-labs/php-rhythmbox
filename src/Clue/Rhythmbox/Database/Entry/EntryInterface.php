<?php

namespace Clue\Rhythmbox\Database\Entry;

interface EntryInterface
{
    public function getType();

    public function getAttribute($name);

    public function getAttributes();
}
