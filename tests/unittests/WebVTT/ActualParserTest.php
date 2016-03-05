<?php namespace ThijsR\Subtitles\UnitTests\WebVTT;

use ThijsR\Subtitles\Test\BaseTestCase;
use ThijsR\Subtitles\WebVTT\ActualParser;

class ActualParserTest extends BaseTestCase
{
    protected $parser;
    public function setUp()
    {
        parent::setUp();

        $this->parser = new ActualParser();
    }

    public function testInstantiation ()
    {
        $this->assertInstanceOf(ActualParser::class, $this->parser);
    }

    public function testAllNullCharactersAreReplacedByReplacementCharacters ()
    {
        $string = "";
        $this->parser->parseString($string);
    }
}