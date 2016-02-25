<?php namespace Thijs\PhpSrt;

class SrtScanner
{
    const SRT_STATE_SUB_NUMBER = 0;
    const SRT_STATE_TIME       = 1;
    const SRT_STATE_TEXT       = 2;
    const SRT_STATE_BLANK      = 3;

    /**
     * @var int
     */
    private $current_state = self::SRT_STATE_SUB_NUMBER;

    private $current_text = "";
    private $current_time = "";
    private $current_num = 0;

    /**
     * @param string $file_path
     * @return SrtFile
     */
    public function readFile ($file_path)
    {
        return self::readLines(self::getFileLines($file_path));
    }

    /**
     * @param string $file_path
     * @return array
     */
    protected function getFileLines ($file_path)
    {
        return file($file_path);
    }

    /**
     * @param array $lines
     * @return SrtFile
     */
    public function readLines (array $lines)
    {
        $srt_file = new SrtFile();
        var_dump($lines);
        foreach ($lines as $line)
        {
            $this->readLine($srt_file, $line);
        }

        return $srt_file;
    }

    /**
     * @param SrtFile $srt_file
     * @param string $line
     */
    public function readLine(SrtFile $srt_file, $line)
    {
        switch($this->current_state) {
            case self::SRT_STATE_SUB_NUMBER:
                $this->current_num = trim($line);
                $this->current_state = self::SRT_STATE_TIME;
                break;

            case self::SRT_STATE_TIME:
                $this->current_time = trim($line);
                $this->current_state = self::SRT_STATE_TEXT;

                break;

            case self::SRT_STATE_TEXT:
                var_dump($line);
                if (trim($line) == "") {
                    $subtitle = new Subtitle();
                    $subtitle->number = $this->current_num;
                    $subtitle->text = $this->current_text;

                    list($subtitle->start_time, $subtitle->stop_time) = \explode(" --> ", $this->current_time);

                    $srt_file->addSubtitle($subtitle);
                    $this->clearState();
                }
                else
                {
                    $this->current_text .= $line;
                }

                break;
        }
    }

    private function clearState ()
    {
        $this->current_state = self::SRT_STATE_SUB_NUMBER;
        $this->current_text = "";
        $this->current_time = "";
        $this->current_num = 0;
    }
}