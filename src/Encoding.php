<?php namespace ThijsR\Subtitles;


class Encoding
{
    const UTF_8 = "UTF-8";
    CONST ASCII = "ASCII";

    public static function toUtf8 ($input, $from_encoding = NULL)
    {
        return mb_convert_encoding($input, self::UTF_8, $from_encoding ?: self::guessEncoding($input));
    }

    public static function guessEncoding ($input)
    {
        return mb_detect_encoding($input);
    }
}