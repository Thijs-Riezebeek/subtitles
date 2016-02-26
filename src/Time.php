<?php namespace ThijsR\Subtitles;

class Time
{
    /*
     * These should match the member variable below.
     */
    const MILLISECONDS = "milliseconds";
    const SECONDS = "seconds";
    const MINUTES = "minutes";

    /**
     * @var int
     */
    protected $hours;

    /**
     * @var int
     */
    protected $minutes;

    /**
     * @var int
     */
    protected $seconds;

    /**
     * @var int
     */
    protected $milliseconds;

    /**
     * @param string $time_string
     * @return self
     */
    public static function fromString ($time_string)
    {
        list($hours_minutes_seconds, $milliseconds) = explode(",", $time_string);
        list($hours, $minutes, $seconds) = explode(":", $hours_minutes_seconds);

        return new self($hours, $minutes, $seconds, $milliseconds);
    }

    /**
     * Time constructor.
     * @param int $hours
     * @param int $minutes
     * @param int $seconds
     * @param int $milliseconds
     */
    public function __construct($hours, $minutes, $seconds, $milliseconds)
    {
        $this->hours = (int) $hours;
        $this->minutes = (int) $minutes;
        $this->seconds = (int) $seconds;
        $this->milliseconds = (int) $milliseconds;
    }

    /**
     * @return string
     */
    public function toString ()
    {
        return sprintf("%02d:%02d:%02d,%03d", $this->hours, $this->minutes, $this->seconds, $this->milliseconds);
    }

    /**
     * @param int $milliseconds
     */
    public function addMilliseconds ($milliseconds)
    {
        $this->add(self::MILLISECONDS, $milliseconds, 1000);
    }

    /**
     * Works for both positive and negative numbers.
     *
     * @param string $unit
     * @param int $amount
     * @param int $max
     */
    protected function add($unit, $amount, $max)
    {
        $new_amount = $this->$unit + $amount;

        if ($new_amount < 0)
        {
            // Borrow an extra one from the next unit so that the current unit stays positive
            $overflow_amount = (int) ($new_amount / $max) - 1;
        }
        else
        {
            $overflow_amount = (int)($new_amount / $max);
        }
        $remaining_amount = $new_amount - $overflow_amount * $max;

        $this->$unit = $remaining_amount;
        if ($overflow_amount != 0)
        {
            $this->callNextAddMethod($unit, $overflow_amount);
        }
    }

    private function callNextAddMethod($unit, $amount)
    {
        if ($unit == self::MILLISECONDS) $this->addSeconds($amount);
        elseif ($unit == self::SECONDS) $this->addMinutes($amount);
        elseif ($unit == self::MINUTES) $this->addHours($amount);
        else return;
    }

    /**
     * @param int $seconds
     */
    public function addSeconds ($seconds)
    {
        $this->add(self::SECONDS, $seconds, 60);
    }

    /**
     * @param int $minutes
     */
    public function addMinutes ($minutes)
    {
        $this->add(self::MINUTES, $minutes, 60);
    }

    /**
     * @param int $hours
     */
    public function addHours ($hours)
    {
        $this->hours += $hours;
    }
}