<?php namespace ThijsR\Subtitles\SubRip;

class File
{
    /**
     * @var Subtitle[]
     */
    protected $subtitles = [];

    /**
     * @var string
     */
    protected $line_ending = PHP_EOL;

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
     * @return string
     */
    public function getLineEnding ()
    {
        return $this->line_ending;
    }

    /**
     * @param string $line_ending
     */
    public function setLineEnding ($line_ending)
    {
        $this->line_ending = $line_ending;
    }
}