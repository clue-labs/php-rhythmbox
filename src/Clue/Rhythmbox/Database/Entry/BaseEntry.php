<?php

namespace Clue\Rhythmbox\Database\Entry;

use Clue\Rhythmbox\Database\Entry\EntryInterface;

abstract class BaseEntry implements EntryInterface
{
    private $data;

    protected static $ints = array();

    public function __construct($data)
    {
        $this->data = array('type' => $this->getType()) + $data;

        foreach (static::$ints as $key) {
            if (isset($data[$key])) {
                $this->data[$key] = (int)$data[$key];
            }
        }
    }

    public function getAttribute($name)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }

        // TODO:
        // throw new \Exception('Invalid property "' . $name . '" in ' . json_encode($this->data));
        return null;
    }

    public function getAttributes()
    {
        return $this->data;
    }
}
