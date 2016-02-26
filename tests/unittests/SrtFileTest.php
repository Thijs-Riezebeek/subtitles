<?php

use ThijsR\Subtitles\SubRip;
use ThijsR\Subtitles\Subtitle;

class SrtModifierTest extends PHPUnit_Framework_TestCase
{
    private function setUpSrtFileWithSingleSubtitle ($number, $start_time, $end_time, $text = NULL)
    {
        $srt_file = new SubRip\File();
        $subtitle = new Subtitle($number, $start_time, $end_time, $text);
        $srt_file->addSubtitle($subtitle);

        return $srt_file;
    }

    public function testAddDelayInMsWorksForPositiveDelays ()
    {
        $srt_file = $this->setUpSrtFileWithSingleSubtitle(1, "00:07:23,177", "00:07:25,721");

        SubRip\Modifier::addDelayInMs($srt_file, 1000);
        $this->assertEquals("00:07:24,177", $srt_file->getSubtitles()[0]->getFormattedStartTime());
        $this->assertEquals("00:07:26,721", $srt_file->getSubtitles()[0]->getFormattedStopTime());

        SubRip\Modifier::addDelayInMs($srt_file, 278);
        $this->assertEquals("00:07:24,455", $srt_file->getSubtitles()[0]->getFormattedStartTime());
        $this->assertEquals("00:07:26,999", $srt_file->getSubtitles()[0]->getFormattedStopTime());

        SubRip\Modifier::addDelayInMs($srt_file, 1);
        $this->assertEquals("00:07:24,456", $srt_file->getSubtitles()[0]->getFormattedStartTime());
        $this->assertEquals("00:07:27,000", $srt_file->getSubtitles()[0]->getFormattedStopTime());
    }

    public function testAddDelayInMsWorksForNegativeDelays ()
    {
        $srt_file = $this->setUpSrtFileWithSingleSubtitle(1, "00:07:23,177", "00:07:25,721");

        SubRip\Modifier::addDelayInMs($srt_file, -1000);
        $this->assertEquals("00:07:22,177", $srt_file->getSubtitles()[0]->getFormattedStartTime());
        $this->assertEquals("00:07:24,721", $srt_file->getSubtitles()[0]->getFormattedStopTime());

        SubRip\Modifier::addDelayInMs($srt_file, -278);
        $this->assertEquals("00:07:21,899", $srt_file->getSubtitles()[0]->getFormattedStartTime());
        $this->assertEquals("00:07:24,443", $srt_file->getSubtitles()[0]->getFormattedStopTime());

        SubRip\Modifier::addDelayInMs($srt_file, -1);
        $this->assertEquals("00:07:21,898", $srt_file->getSubtitles()[0]->getFormattedStartTime());
        $this->assertEquals("00:07:24,442", $srt_file->getSubtitles()[0]->getFormattedStopTime());
    }
}