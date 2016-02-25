<?php

class SrtScannerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Thijs\PhpSrt\SrtScanner
     */
    private $srt_scanner;

    public function setUp()
    {
        parent::setUp();

        $this->srt_scanner = new \Thijs\PhpSrt\SrtScanner();
    }

    public function testReadFileReturnsEmptySrtFileWhenFileEmpty ()
    {
        $srt_file = $this->srt_scanner->readFile(__DIR__ . "/../empty.srt");

        $this->assertInstanceOf("Thijs\\PhpSrt\\SrtFile", $srt_file);
        $this->assertEquals(0, $srt_file->subtitleCount());

    }

    public function testReadFileReturnsSrtFileWithSingleSubtitleWhenFileHasOneSubtitle ()
    {
        $srt_file = $this->srt_scanner->readFile(__DIR__ . "/../single.srt");

        var_dump($srt_file);

        $this->assertInstanceOf("Thijs\\PhpSrt\\SrtFile", $srt_file);
        $this->assertEquals(1, $srt_file->subtitleCount());
    }
}