<?php namespace ThijsR\Subtitles;

class Sanitizer
{
    const NULL_CHAR        = '\u0000';
    const REPLACEMENT_CHAR = '\uFFFD';

    public static function replaceNullCharacters($input)
    {
        return str_replace(
            self::getUnicodeChar(self::NULL_CHAR),
            self::getUnicodeChar(self::REPLACEMENT_CHAR),
            $input
        );
    }

    protected static function getUnicodeChar ($unicode_char)
    {
        return json_decode('"' . $unicode_char . '"');
    }

    public static function ensureOnlyLineFeedChars($input)
    {
        $input = str_replace("\r\n", "\n", $input);
        $input = str_replace("\r", "\n", $input);

        return $input;
    }
}