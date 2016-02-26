<?php namespace ThijsR\Subtitles\SubRip;

use \ThijsR\Subtitles\Subtitle;

class File
{
    /**
     * @var \ThijsR\Subtitles\Subtitle[]
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
}