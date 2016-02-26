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
        foreach ($srt_file->getSubtitles() as $subtitle)
        {
            $new_file .= $subtitle->toString() . "\n\n";
        }

        return $new_file;
    }
}