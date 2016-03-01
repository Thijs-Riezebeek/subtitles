<?php

use ThijsR\Subtitles\SubRip;
use ThijsR\Subtitles\Subtitle;
use ThijsR\Subtitles\Test\BaseTestCase;

class SrtReaderWriterIntegrationTest extends BaseTestCase
{
    /**
     * @param string $filename
     *
     * @dataProvider dpCorrectSrtFiles
     */
    public function testWriterOutputMatchesReaderInputForCorrectFiles ($filename)
    {
        $file_location = $this->getSubRipFileLocation($filename);
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
            ["full.srt"],
            ["empty.srt"],
            ["single.srt"],
            ["non-utf8-win-eol.srt"],
        ];
    }
}