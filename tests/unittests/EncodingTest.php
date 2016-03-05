<?php namespace ThijsR\Subtitles\UnitTests;

use ThijsR\Subtitles\Encoding;
use ThijsR\Subtitles\Test\BaseTestCase;

class EncodingTest extends BaseTestCase
{
    /**
     * @dataProvider dpStringAndEncoding
     *
     * @param string $input
     * @param string $expected_encoding
     */
    public function testGuessEncoding ($input, $expected_encoding)
    {
        $input = json_decode('"' . $input. '"');

        $this->assertEquals($expected_encoding, Encoding::guessEncoding($input));
    }

    public function dpStringAndEncoding ()
    {
        return [
            ["Hello world", Encoding::ASCII],
            ["Some sentence.\n", Encoding::ASCII],
            ['Some sentence.\u4ced', Encoding::UTF_8],
        ];
    }
}