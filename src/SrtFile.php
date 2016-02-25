<?php namespace Thijs\PhpSrt;


class SrtFile
{
    /**
     * @var Subtitle[]
     */
    private $subtitles = [];

    /**
     * @return int
     */
    public function subtitleCount ()
    {
        return count($this->subtitles);
    }

    /**
     * @param Subtitle $subtitle
     */
    public function addSubtitle (Subtitle $subtitle)
    {
        $this->subtitles[] = $subtitle;
    }

    /**
     * @return Subtitle[]
     */
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