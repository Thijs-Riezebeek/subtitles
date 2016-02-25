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
}