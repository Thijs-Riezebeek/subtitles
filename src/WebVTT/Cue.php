<?php namespace ThijsR\Subtitles\WebVTT;


class Cue
{
    const ALIGN_START_ALIGNMENT = "align:start";
    const ALIGN_CENTER_ALIGNMENT = "align:center";
    const ALIGN_END_ALIGNMENT = "align:end";

    const DIR_HORIZONTAL = "horizontal";
    const DIR_VERTICAL_GROWING_LEFT = "vertical:rl";
    const DIR_VERTICAL_GROWING_RIGHT = "vertical:lr";

    private $identifier = "";

    private $pause_on_exit = FALSE;

    private $cue_snap_to_lines = TRUE;

    private $cue_region = NULL;

    private $cue_writing_direction = self::DIR_HORIZONTAL;

    private $cue_line = "auto";

    private $cue_line_alignment = self::ALIGN_START_ALIGNMENT;
}