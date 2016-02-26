<?php namespace ThijsR\Subtitles;

class Subtitle
{
    /**
     * @var int
     */
    public $number;

    /**
     * @var string
     */
    public $text;

    /**
     * @var Time
     */
    public $start_time;

    /**
     * @var Time
     */
    public $stop_time;

    public function __construct($number = NULL, $start_Time = NULL, $stop_time = NULL, $text = NULL)
    {
        $this->number = $number;
        $this->text = $text;

        if (!empty($start_Time))
        {
            $this->start_time = Time::fromString($start_Time);
        }

        if (!empty($stop_time))
        {
            $this->stop_time = Time::fromString($stop_time);
        }
    }

    /**
     * @param int $delay_in_milliseconds
     */
    public function addDelayInMilliseconds ($delay_in_milliseconds)
    {
        $this->start_time->addMilliseconds($delay_in_milliseconds);
        $this->stop_time->addMilliseconds($delay_in_milliseconds);
    }

    /**
     * @return string
     */
    public function getFormattedStartTime ()
    {
        return $this->start_time->toString();
    }

    /**
     * @return string
     */
    public function getFormattedStopTime ()
    {
        return $this->stop_time->toString();
    }

    public function toString ()
    {
        return sprintf("%d\n%s --> %s\n%s",
            $this->number, $this->getFormattedStartTime(), $this->getFormattedStopTime(), $this->text);
    }
}