<?php namespace Thijs\PhpSrt;


class SrtFile
{
    /**
     * @var Subtitle[]
     */
    private $subtitles = [];

    public function subtitleCount ()
    {
        return count($this->subtitles);
    }

    public function addSubtitle (Subtitle $subtitle)
    {
        $this->subtitles[] = $subtitle;
    }

    public function getSubtitles ()
    {
        return $this->subtitles;
    }

    /**
     * @param int $delay_in_milliseconds
     */
    public function addDelayInMilliseconds ($delay_in_milliseconds)
    {
        foreach ($this->subtitles as $subtitle)
        {
            $subtitle->addDelayInMilliseconds($delay_in_milliseconds);
        }
    }
}