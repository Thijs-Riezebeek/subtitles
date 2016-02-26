<?php

use ThijsR\Subtitles\SubRip;

class TimeTest extends PHPUnit_Framework_TestCase
{
    public function testFromStringCreatesCorrectTimeObject ()
    {
        $this->assertEquals("02:15:48,429", SubRip\Time::fromString("02:15:48,429")->toString());
    }

    public function testAddZeroDoesNotAlterTime ()
    {
        $time = SubRip\Time::fromString("02:15:48,429");

        $time->addMilliseconds(0);
        $time->addSeconds(0);
        $time->addMinutes(0);
        $time->addHours(0);
        $this->assertEquals($time->toString(), "02:15:48,429");
    }

    public function testAddOneWorksCorrectly ()
    {
        $time = SubRip\Time::fromString("02:15:48,429");

        $time->addMilliseconds(1);
        $time->addSeconds(1);
        $time->addMinutes(1);
        $time->addHours(1);
        $this->assertEquals("03:16:49,430", $time->toString());
    }

    public function testAddWorksForPositiveNumbersWithOverflow ()
    {
        $time = SubRip\Time::fromString("02:15:48,429");

        $time->addMilliseconds(600);
        $time->addSeconds(11);
        $time->addMinutes(345);
        $this->assertEquals("08:01:00,029", $time->toString());
    }

    public function testAddWorksWithNegativeNumbers ()
    {
        $time = SubRip\Time::fromString("02:15:48,429");

        $time->addMilliseconds(-1);
        $time->addSeconds(-1);
        $time->addMinutes(-1);
        $time->addHours(-1);
        $this->assertEquals("01:14:47,428", $time->toString());
    }

    public function testAddWorksWithNegativeNumbersWithUnderflow ()
    {
        $time = SubRip\Time::fromString("02:15:48,429");

        $time->addMilliseconds(-500);
        $time->addSeconds(-48);
        $time->addMinutes(-14);
        $time->addHours(-1);
        $this->assertEquals("01:00:59,929", $time->toString());
    }
}