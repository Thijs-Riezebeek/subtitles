<?php namespace Thijs\PhpSrt;

class SrtReader
{
    /**
     * @param string $file_path
     * @return SrtFile
     */
    public static function readFile ($file_path)
    {
        return self::scanFileContents(self::getFileContents($file_path));
    }

    /**
     * @param string $file_path
     * @return array
     */
    protected static function getFileContents ($file_path)
    {
        return file_get_contents($file_path);
    }

    /**
     * @param string $file_contents
     * @return SrtFile
     */
    protected static function scanFileContents ($file_contents)
    {
        $blocks = explode("\n\n", $file_contents);

        return self::scanBlocks($blocks);
    }

    /**
     * @param array $blocks
     * @return SrtFile
     */
    protected static function scanBlocks(array $blocks)
    {
        $srt_file = new SrtFile();
        foreach ($blocks as $block)
        {
            if (trim($block) === "")
            {
                continue;
            }

            $srt_file->addSubtitle(self::createSubtitleFromBlock($block));
        }

        return $srt_file;
    }

    /**
     * @param string $block
     * @return Subtitle
     */
    protected static function createSubtitleFromBlock($block)
    {
        $matches = self::matchBlockToRegex($block);

        $subtitle = new Subtitle();
        $subtitle->number = trim($matches[1]);
        $subtitle->start_time = Time::fromString($matches[2]);
        $subtitle->stop_time = Time::fromString($matches[3]);
        $subtitle->text = trim($matches[4]);

        return $subtitle;
    }

    protected static function matchBlockToRegex ($block)
    {
        preg_match("/(\d*)\r?\n(\d\d:\d\d:\d\d,\d\d\d) --> (\d\d:\d\d:\d\d,\d\d\d)\r?\n(.*)/s", $block, $matches);

        return $matches;
    }
}