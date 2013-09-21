<?php

namespace Clue\Rhythmbox\Database;

use SimpleXmlElement;

class XmlDatabase extends BaseDatabase
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
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
