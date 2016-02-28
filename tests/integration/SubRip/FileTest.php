<?php

use ThijsR\Subtitles\SubRip;
use ThijsR\Subtitles\Subtitle;

class SrtReaderWriterIntegrationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param string $file_location
     *
     * @dataProvider dpCorrectSrtFiles
     */
    public function testWriterOutputMatchesReaderInputForCorrectFiles ($file_location)
    {
        $file_contents = file_get_contents($file_location);
        $srt_file = SubRip\Reader::readFile($file_location);

        ob_start();
        SubRip\Writer::writeFile($srt_file, "php://output");
        $new_file_contents = ob_get_contents();
        ob_end_clean();

        $this->assertEquals($file_contents, $new_file_contents);
        $this->assertEquals($file_contents, SubRip\Writer::writeFileToString($srt_file));
    }

    public function dpCorrectSrtFiles ()
    {
        return [
            [__DIR__ . "/../../full.srt"],
            [__DIR__ . "/../../empty.srt"],
            [__DIR__ . "/../../single.srt"],
            [__DIR__ . "/../../non-utf8-win-eol.srt"],
        ];
    }
}