<?php namespace ThijsR\Subtitles\SubRip;

class File
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
}