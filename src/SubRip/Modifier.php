<?php namespace ThijsR\Subtitles\SubRip;


class Modifier
{
    /**
     * @param File $srt_file
     * @param int  $delay_in_milliseconds
     */
    public static function addDelayInMs (File $srt_file, $delay_in_milliseconds)
    {
        foreach ($srt_file->getSubtitles() as $subtitle)
        {
            $subtitle->addDelayInMilliseconds($delay_in_milliseconds);
        }
    }
}