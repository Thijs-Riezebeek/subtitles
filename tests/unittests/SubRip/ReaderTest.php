<?php

use ThijsR\Subtitles\SubRip;
use ThijsR\Subtitles\Test\BaseTestCase;

class ReaderTest extends BaseTestCase
{
    public function testReadFileReturnsEmptySrtFileWhenFileEmpty ()
    {
        $srt_file = SubRip\Reader::readFile($this->getSubRipFileLocation("empty.srt"));

        $this->assertInstanceOf("ThijsR\\Subtitles\\SubRip\\File", $srt_file);
        $this->assertEquals(0, $srt_file->subtitleCount());
    }

    public function testReadFileReturnsCorrectSrtFileWhenFileContainsOneSubtitle ()
    {
        $srt_file = SubRip\Reader::readFile($this->getSubRipFileLocation("single.srt"));

        $this->assertEquals(1, $srt_file->subtitleCount());

        $this->assertEquals(1, $srt_file->getSubtitles()[0]->number);
        $this->assertEquals("00:01:55,599", $srt_file->getSubtitles()[0]->getFormattedStartTime());
        $this->assertEquals("00:01:56,517", $srt_file->getSubtitles()[0]->getFormattedStopTime());
        $this->assertEquals("Hey, Pop.", $srt_file->getSubtitles()[0]->text);
    }

    public function testReadFileReturnsCorrectSrtFileWhenFileContains50Subtitles ()
    {
        $srt_file = SubRip\Reader::readFile($this->getSubRipFileLocation("multiple.srt"));

        $this->assertEquals(50, $srt_file->subtitleCount());

        $this->assertEquals(35, $srt_file->getSubtitles()[34]->number);
        $this->assertEquals("00:05:39,365", $srt_file->getSubtitles()[34]->getFormattedStartTime());
        $this->assertEquals("00:05:43,243", $srt_file->getSubtitles()[34]->getFormattedStopTime());
        $this->assertEquals("\"...said President Underwood\nduring a press conference yesterday.", $srt_file->getSubtitles()[34]->text);

        $this->assertEquals(50, $srt_file->getSubtitles()[49]->number);
        $this->assertEquals("00:07:23,177", $srt_file->getSubtitles()[49]->getFormattedStartTime());
        $this->assertEquals("00:07:25,721", $srt_file->getSubtitles()[49]->getFormattedStopTime());
        $this->assertEquals("You're getting the very best\nof care, okay?", $srt_file->getSubtitles()[49]->text);
    }

    public function testReadFileReturnsCorrectFileWhenFileHasNoTrailingNewline ()
    {
        $srt_file = SubRip\Reader::readFile($this->getSubRipFileLocation("no-trailing-newline.srt"));

        $this->assertEquals(5, $srt_file->subtitleCount());

        $this->assertEquals("has visited Gaffney.", $srt_file->getSubtitles()[4]->text);
    }
}