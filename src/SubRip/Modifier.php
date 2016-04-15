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

    /**
     * Will start numbering the subtitles in the SubRip File in the order in which
     * they were added, starting from 1.
     *
     * @param File $srt_file
     */
    public static function restoreNumbering (File $srt_file)
    {
        $amount_of_subtitles = count($srt_file->getSubtitles());

        for ($i = 0; $i < $amount_of_subtitles; $i++)
        {
            $srt_file->getSubtitles()[$i]->number = $i + 1;
        }
    }
}