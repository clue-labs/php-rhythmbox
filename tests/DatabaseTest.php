<?php

class DatabaseTest extends TestCase
{
    public function testLoad()
    {
        $database = $this->createDatabase();

        $database->getRadios();
    }
}
