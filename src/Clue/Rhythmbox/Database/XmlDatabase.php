<?php

namespace Clue\Rhythmbox\Database;

use SimpleXmlElement;
use Clue\Rhythmbox\Database\Entry\Song;
use Clue\Rhythmbox\Database\Entry\Radio;
use Clue\Rhythmbox\Database\Entry\Ignore;

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
            $one = array();
            foreach ($entry->children() as $param) {
                /* @var $param SimpleXmlElement */
                $one[$param->getName()] = (string)$param;
            }

            $all[] = $this->createEntry((string)$entry['type'], $one);
        }

        return $all;
    }

    private function createEntry($type, $data)
    {
        if ($type === 'song') {
            return new Song($data);
        } elseif ($type === 'iradio') {
            return new Radio($data);
        } elseif ($type === 'ignore') {
            return new Ignore($data);
        } else {
            throw new Exception('Unkown entry type "' . $type . '"');
        }
    }

    private function getXml()
    {
        $contents = file_get_contents($this->path);

        return new SimpleXMLElement($contents);
    }
}
