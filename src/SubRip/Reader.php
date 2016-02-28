<?php namespace ThijsR\Subtitles\SubRip;

class Reader
{
    /**
     * @param string $file_path
     * @return File
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
     * @return File
     */
    protected static function scanFileContents ($file_contents)
    {
        $srt_file = new File();

        try
        {
            $srt_file->setLineEnding(self::getFileLineEnding($file_contents));
        }
        catch (NoLineEndingsFoundException $e)
        {
            // Probably a file with no subtitles at all (empty)
            return $srt_file;
        }

        $block_separator = $srt_file->getLineEnding() . $srt_file->getLineEnding();
        $blocks = explode($block_separator, $file_contents);
        self::scanBlocksIntoFile($srt_file, $blocks);

        return $srt_file;
    }

    /**
     * @param string $file_contents
     * @return string
     * @throws NoLineEndingsFoundException
     */
    private static function getFileLineEnding($file_contents)
    {
        // Search for double newlines that break up the blocks
        if (preg_match("/(\r\n\r\n)/s", $file_contents))
        {
            return "\r\n";
        }
        if (preg_match("/(\n\r\n\r)/s", $file_contents))
        {
            return "\n\r";
        }
        if (preg_match("/(\n\n)/s", $file_contents))
        {
            return "\n";
        }
        if (preg_match("/(\r\r)/s", $file_contents))
        {
            return "\r";
        }

        // No double newlines so far, meaning a file with one subtitle
        if (preg_match("/(\r\n)/s", $file_contents))
        {
            return "\r\n";
        }
        if (preg_match("/(\n\r)/s", $file_contents))
        {
            return "\n\r";
        }
        if (preg_match("/(\n)/s", $file_contents))
        {
            return "\n";
        }
        if (preg_match("/(\r)/s", $file_contents))
        {
            return "\r";
        }

        throw new NoLineEndingsFoundException("");
    }

    /**
     * @param File $srt_file
     * @param array $blocks
     */
    protected static function scanBlocksIntoFile(File $srt_file, array $blocks)
    {
        foreach ($blocks as $block)
        {
            if (trim($block) === "")
            {
                continue;
            }

            $srt_file->addSubtitle(self::createSubtitleFromBlock($block));
        }
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

    /**
     * @param string $block
     * @return mixed
     */
    protected static function matchBlockToRegex ($block)
    {
        preg_match('/(\d*)(?:\r\n|\n\r|\n|\r)(\d{1,3}:\d{1,2}:\d{1,2},\d{1,3}) --> (\d{1,3}:\d{1,2}:\d{1,2},\d{1,3})(?:\r\n|\n\r|\n|\r)(.*)/s', $block, $matches);

        return $matches;
    }
}