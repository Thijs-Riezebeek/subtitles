<?php namespace ThijsR\Subtitles\SubRip;


class Writer
{
    /**
     * @param File   $srt_file
     * @param string $destination
     */
    public static function writeFile (File $srt_file, $destination)
    {
        $file_contents = self::createFileContents($srt_file);

        file_put_contents($destination, $file_contents);
    }

    /**
     * @param File $srt_file
     * @return string
     */
    public static function writeFileToString (File $srt_file)
    {
        return self::createFileContents($srt_file);
    }

    /**
     * @param File $srt_file
     * @return string
     */
    private static function createFileContents (File $srt_file)
    {
        $new_file = "";
        $subtitles = $srt_file->getSubtitles();
        $subtitle_count = $srt_file->subtitleCount();
        $line_ending = $srt_file->getLineEnding();

        for ($i = 0; $i < $subtitle_count; $i += 1)
        {
            $new_file .= self::subtitleToString($subtitles[$i], $line_ending) . $line_ending;
            if (!self::isLastSubtitle($i, $subtitle_count))
            {
                $new_file .= $line_ending;
            }
        }

        return $new_file;
    }

    protected static function subtitleToString (Subtitle $subtitle, $line_ending)
    {
        return sprintf("%d$line_ending%s --> %s$line_ending%s",
            $subtitle->number, $subtitle->getFormattedStartTime(), $subtitle->getFormattedStopTime(), $subtitle->text);
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