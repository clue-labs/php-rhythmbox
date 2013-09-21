<?php

namespace Clue\Rhythmbox\Playlist;

use Clue\Rhythmbox\Database;
use SimpleXMLElement;

class AutomaticPlaylist extends PlaylistBase
{
    private $limits = array(
        // size limit in given in MB (check property "file-size" in bytes)
        'size' => 'file-size',

        // time limit in seconds (check property "duration" in seconds)
        'time' => 'duration',

        // limited by number of entries (no need to check any properties)
        'count' => null
    );

    public function getSortKey()
    {
        $key = $this->getAttribute('sort-key');

        // Artist => artist
        // FirstSeen => first-seen

        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $key));
    }

    public function getSortDirection()
    {
        // 0 = normal/ASC, 1 = reverse/DESC
        return (int)$this->getAttribute('sort-direction');
    }

    public function hasLimit()
    {
        return ($this->getLimitMax() !== null);
    }

    public function getLimitProperty()
    {
        foreach ($this->limits as $name => $property) {
            if (isset($this->xml['limit-' . $name])) {
                return $property;
            }
        }

        return null;
    }

    public function getLimitMax()
    {
        $max = null;

        foreach ($this->limits as $name => $property) {
            if (isset($this->xml['limit-' . $name])) {
                $max = (int)$this->xml['limit-' . $name];
            }
        }

        $by = $this->getLimitProperty();
        if ($by === 'file-size') {
            // maximum size limit in given in MB (not MiB)
            // if maximum size is given in GB, it will be multiplied by 1000
            // return maximum size in bytes
            $max *= 1000000;
        }

        return $max;
    }

    public function getSongsFromDatabase(Database $database)
    {
        $songs = $database->getSongs();

        // filter by conjunction
        foreach ($songs as $i => $song) {
            if (!$this->checkConjunction($song, $this->xml->conjunction)) {
                unset($songs[$i]);
            }
        }

        // filter by limits
        $limit = $this->getLimitMax();
        if ($limit !== null) {

            // sort for checking limits, expose sorting to outside
            $key = $this->getSortKey();
            $reverse = $this->getSortDirection();

            uasort($songs, function ($a, $b) use ($key, $reverse) {
                $a = $a[$key];
                $b = $b[$key];

                if ($reverse) {
                    $c = $a;
                    $a = $b;
                    $b = $c;
                }

                if ($a < $b) {
                    return -1;
                } elseif ($a > $b) {
                    return 1;
                } else {
                    return 0;
                }
            });

            $current = 0;
            $property = $this->getLimitProperty();

            foreach ($songs as $i => $song) {
                $now = 1;
                if ($property !== null) {
                    $now = (int)$song[$property];
                }

                $current += $now;
                if ($current > $limit) {
                    unset($songs[$i]);
                }
            }
        }


        return $songs;
    }

    /**
     * conjunction (AND)
     *
     * uses short-circuit evaluation to reject when first check is rejected
     *
     * @param array             $song
     * @param SimpleXMLElement $conjunction
     * @return boolean
     */
    protected function checkConjunction($song, SimpleXMLElement $conjunction)
    {
        foreach ($conjunction->children() as $child) {
            /* @var $child SimpleXMLElement */

            if (!$this->checkOne($song, $child)) {
                return false;
            }
        }

        return true;
    }

    /**
     * disjunction (OR)
     *
     * uses short-circuit evaluation to accept when first check is accepted.
     *
     *
     * thus, an empty list of disjunctions *would* fail, but I have yet to see
     * one for rhythmbox playlists
     *
     * @param array $song
     * @param SimpleXMLElement $disjunction
     */
    protected function checkDisjunction($song, \SimpleXMLElement $disjunction)
    {
        foreach ($disjunction->children() as $child) {
            /* @var $child SimpleXMLElement */

            if ($child->getName() === 'disjunction') continue;

            if (!$this->checkOne($song, $child)) {
                return true;
            }
        }

        return false;
    }

    protected function checkOne($song, SimpleXMLElement $filter)
    {
        $name = $filter->getName();
        if ($name === 'subquery') {
            // each subquery always contains a conjunction element with the actual filters
            $junction = $filter->conjunction;

            // if the conjunction element contains a disjunction element, it is OR'ed instead of AND'ed
            if (isset($junction->disjunction)) {
                return $this->checkDisjunction($song, $junction);
            } else {
                return $this->checkConjunction($song, $junction);
            }
        }

        $property = (string)$filter['prop'];

        if (isset($song[$property])) {
            $actual = $song[$property];
        } else {
            $actual = null;
            //throw new \Exception('Invalid property "' . $property . '" in ' . json_encode($song));
        }

        $expected = (string)$filter;
        if ($property === 'rating') {
            // TODO: clean up
            // TODO: seems to obey locale
            // <greater prop="rating">3,000000</greater>
            $expected = (float)$expected;
        }

        if ($name === 'equals') {
            return ($actual == $expected);
        } elseif ($name === 'not-equal') {
            return ($actual != $expected);
        } elseif ($name === 'less') {
            return ($actual <= $expected);
        } elseif ($name === 'greater') {
            return ($actual >= $expected);
        } elseif ($name === 'prefix') {
            return (strpos($expected, $actual) === 0);
        } elseif ($name === 'like') {
            return (strpos($expected, $actual) !== false);
        } elseif ($name === 'not-like') {
            return (strpos($expected, $actual) === false);
        } elseif ($name === 'suffix') {
            return (substr($actual, -strlen($expected)) === $expected);
        } elseif ($name === 'current-time-within') {
            return (abs(time() - $actual) <= $expected);
        } elseif ($name === 'current-time-not-within') {
            return (abs(time() - $actual) > $expected);
        } else {
            throw new \RuntimeException('Unknown filter "' . $name . '"');
        }
    }
}
