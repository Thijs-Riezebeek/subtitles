<?php namespace ThijsR\Subtitles\WebVTT;


class Cue
{
    const LINE_ALIGNMENT_START = "align:start";
    const LINE_ALIGNMENT_CENTER = "align:center";
    const LINE_ALIGNMENT_END = "align:end";

    const TEXT_ALIGNMENT_START = "align:start";
    const TEXT_ALIGNMENT_CENTER = "align:center";
    const TEXT_ALIGNMENT_END = "align:end";
    const TEXT_ALIGNMENT_RIGHT = "align:end";
    const TEXT_ALIGNMENT_LEFT = "align:end";

    const DIR_HORIZONTAL = "horizontal";
    const DIR_VERTICAL_GROWING_LEFT = "vertical:rl";
    const DIR_VERTICAL_GROWING_RIGHT = "vertical:lr";

    private $identifier = "";

    private $pause_on_exit = FALSE;

    private $snap_to_lines = TRUE;

    private $region = NULL;

    private $writing_direction = self::DIR_HORIZONTAL;

    private $line = "auto";

    private $line_alignment = self::LINE_ALIGNMENT_START;

    private $position = "auto";

    private $position_alignment = "auto";

    private $size = 100;

    private $text_alignment = self::TEXT_ALIGNMENT_CENTER;

    private $text = "";
}