<?php

use ThijsR\Subtitles\SubRip;
use ThijsR\Subtitles\Test\BaseTestCase;

class ModifierTest extends BaseTestCase
{
    private function setUpSrtFileWithSingleSubtitle ($number, $start_time, $end_time, $text = NULL)
    {
        $srt_file = new SubRip\File();
        $subtitle = new SubRip\Subtitle($number, $start_time, $end_time, $text);
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

    /**
     * @dataProvider dpReadableFilesAndSubtitleCount
     *
     * @param string $filename
     * @param int    $expected_subtitle_count
     */
    public function testAddDelayInMSWorksOnAllSubtitlesInFile ($filename, $expected_subtitle_count)
    {
        $srt_file = SubRip\Reader::readFile($this->getSubRipFileLocation($filename));
        $this->assertSame($expected_subtitle_count, $srt_file->subtitleCount());
        $deep_copy = new \DeepCopy\DeepCopy();

        $subtitles = [];
        foreach ($srt_file->getSubtitles() as $subtitle)
        {
            $subtitles[] = $deep_copy->copy($subtitle);
        }

        $delay = 12345678;
        SubRip\Modifier::addDelayInMs($srt_file, $delay);

        $this->assertSubtitlesHaveBeenDelayed($subtitles, $srt_file->getSubtitles(), $delay);
    }

    /**
     * @param SubRip\Subtitle[] $subtitles
     * @param SubRip\Subtitle[] $delayed_subtitles
     * @param int $delay_in_ms
     */
    private function assertSubtitlesHaveBeenDelayed (array $subtitles, array $delayed_subtitles, $delay_in_ms)
    {
        $subtitle_count = count($subtitles);
        $this->assertSameSize($subtitles, $delayed_subtitles);

        for ($i = 0; $i < $subtitle_count; $i += 1)
        {
            $subtitles[$i]->addDelayInMilliseconds($delay_in_ms);

            $this->assertEquals($delayed_subtitles[$i]->start_time->toString(), $subtitles[$i]->start_time->toString());
            $this->assertEquals($delayed_subtitles[$i]->stop_time->toString(), $subtitles[$i]->stop_time->toString());
        }
    }

    public function dpReadableFilesAndSubtitleCount ()
    {
        return [
            ["bad_format_hoc_s02e02_full.srt", 643],
            ["full.srt", 746],
        ];
    }
}