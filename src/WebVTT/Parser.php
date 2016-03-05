<?php namespace ThijsR\Subtitles\WebVTT;

class Parser
{
    private $seen_cue = false;

    private $in_header = false;

    private $position = 0;

    private $regions = [];

    /**
     * @param string $file_location
     * @return File
     * @throws \Exception
     */
    public function parseFile($file_location)
    {
        $input = $this->getSanitizedFileContents($file_location);

        return $this->parseInput($input);
    }

    /**
     * @param string $file_location
     * @return string
     */
    protected function getSanitizedFileContents($file_location)
    {
        $file_contents = file_get_contents($file_location);

        $file_contents = mb_convert_encoding($file_contents, "UTF-16LE", mb_detect_encoding($file_contents));

        $file_contents = str_replace('\u{0000}', '\u{FFFD}', $file_contents);
        $file_contents = str_replace('\u{000D}\u{000A}', '\u{000A}', $file_contents);
        $file_contents = str_replace('\u{000D}', '\u{000A}', $file_contents);

        return $file_contents;
    }

    /**
     * @param string $input
     * @return File
     * @throws \Exception
     */
    protected function parseInput($input)
    {
        if (strlen($input) < 6 ||
            (strlen($input) == 6 && $input !== "WEBVTT") ||
            (strlen($input) > 6 && (substr($input, 0, 6) !== "WEBVTT" || !in_array($input[6], ['\u{0020}', '\u{0009}', '\u{000A}']))))
        {
            // TODO: Throw good exception
            throw new \Exception("File does not start with the correct WebVTT file signature");
        }

        // TODO: Figure out if this should even be done
        $this->position = 7;

        $result = $this->collectCharSequenceTillLineFeed($input);

        if ($this->isPositionPastInputEnd($input, $this->position))
        {
            return new File();
        }

        $this->position++;

        if ($input[$this->position] !== '\u{000A}')
        {
            $this->collectWebVTTBlock($input);
        }
        else
        {
            $this->position++;
        }
    }

    /**
     * @param string $input
     * @return string
     */
    protected function collectCharSequenceTillLineFeed ($input)
    {
        return $this->collectCharacterSequenceExcluding($input, ['\u{000A}']);
    }

    /**
     * @param string $input
     * @param array $stop_characters
     * @return string
     */
    protected function collectCharacterSequenceExcluding($input, array $stop_characters)
    {
        $result = "";

        while (!$this->isPositionPastInputEnd($input, $this->position) && !in_array($input[$this->position], $stop_characters))
        {
            $result .= $input[$this->position];
            $this->position++;
        }

        return $result;
    }

    protected function collectCharacterSequenceIncluding($input, array $allowed_characters)
    {
        $result = "";

        while (!$this->isPositionPastInputEnd($input, ))

        return $result;
    }

    protected function collectWebVTTBlock($input)
    {
        $line_count = 0;
        $previous_position = $this->position;
        $line = "";
        $buffer = "";
        $seen_eof = FALSE;
        $seen_arrow = FALSE;
        $cue = NULL;
        $stylesheet = NULL;
        $region = NULL;

        while (TRUE)
        {
            $line = $this->collectCharSequenceTillLineFeed($input);
            $line_count++;

            if ($this->isPositionPastInputEnd($input, $this->position))
            {
                $seen_eof = TRUE;
            }
            else
            {
                $this->position++;
            }

            if (mb_strpos($line, "-->"))
            {
                if (!$this->in_header && ($line_count === 1 || ($line_count === 2 && $seen_arrow)))
                {
                    $seen_arrow = TRUE;
                    $previous_position = $this->position;

                    $cue = new Cue();
                    $this->collectWebVTTCueTimingsAndSettings($line);

                }
            }
        }
    }

    protected function collectWebVTTCueTimingsAndSettings ($input)
    {
        $cue = new Cue();
        $position = $this->skipWhitespace($input, 0);

        $this->collectWebVTTTimeStamp($input, $position);
    }

    protected function collectWebVTTTimeStamp($input, $position)
    {
        $most_significant_unit = "mins";

        if ($this->isPositionPastInputEnd($input, $position) || !$this->isAsciiDigit($input[$position]))
        {
            // return failure abort
        }

        $this->collectCharacterSequenceExcluding()
    }

    protected function isAsciiDigit ($character)
    {
        return ctype_digit($character);
    }

    protected function skipWhitespace ($input, $position)
    {
        while ($input[$position] == " ") $position++;
        return $position;
    }

    /**
     * @param string $input
     * @return bool
     */
    protected function isPositionPastInputEnd($input, $position)
    {
        return $position >= strlen($input);
    }
}