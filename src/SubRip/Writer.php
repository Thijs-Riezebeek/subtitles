<?php namespace ThijsR\Subtitles\SubRip;


class Writer
{

    public static function writeFile (File $srt_file, $destination)
    {
        $file_contents = self::createFileContents($srt_file);

        file_put_contents($destination, $file_contents);
    }

    private static function createFileContents (File $srt_file)
    {
        $new_file = "";
        $subtitles = $srt_file->getSubtitles();
        $subtitle_count = $srt_file->subtitleCount();

        for ($i = 0; $i < $subtitle_count; $i += 1)
        {
            $new_file .= $subtitles[$i]->toString() . (self::isLastSubtitle($i, $subtitle_count) ? "\n" : "\n\n");
        }

        return $new_file;
    }

    /**
     * @param int $i
     * @param int $subtitle_count
     * @return bool
     */
    private static function isLastSubtitle ($i, $subtitle_count)
    {
        return $i === $subtitle_count - 1;
    }
}