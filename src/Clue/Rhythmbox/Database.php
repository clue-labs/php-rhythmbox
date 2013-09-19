<?php

namespace Clue\Rhythmbox;

use SimpleXmlElement;
use stdClass;

class Database
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

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
        return array_values(array_filter($this->getAll(), function ($one) use ($type) {
            return ($one['type'] === $type);
        }));
    }

    public function getAll()
    {
        $xml = $this->getXml();
        $all = array();

        foreach ($xml->entry as $entry) {
            /* @var $entry SimpleXmlElement */
            $one = array('type' => (string)$entry['type']);
            foreach ($entry->children() as $param) {
                /* @var $param SimpleXmlElement */
                $one[$param->getName()] = (string)$param;
            }

            $all[] = $one;
        }

        return $all;
    }

    private function getXml()
    {
        $contents = file_get_contents($this->path);

        return new SimpleXMLElement($contents);
    }
}
