<?php namespace ThijsR\Subtitles\Test;

class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $filename
     * @return string
     */
    protected function getSubRipFileLocation ($filename)
    {
        return __DIR__ . "/files/subrip/$filename";
    }
}