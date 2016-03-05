<?php namespace ThijsR\Subtitles\UnitTests;

use ThijsR\Subtitles\Sanitizer;
use ThijsR\Subtitles\Test\BaseTestCase;

class SanitizerTest extends BaseTestCase
{

    /**
     * @dataProvider dpJsonStringsWithPossibleNullCharacter
     *
     * @param string $json_string_input
     * @param string $json_string_expected
     */
    public function testReplaceNullCharactersSwapsForReplacementCharacters ($json_string_input, $json_string_expected)
    {
        $input = json_decode('"' . $json_string_input . '"');
        $expected_output = json_decode('"' . $json_string_expected . '"');

        $result = Sanitizer::replaceNullCharacters($input);

        $this->assertSame($expected_output, $result);
    }

    public function dpJsonStringsWithPossibleNullCharacter ()
    {
        return [
            ['This string should stay intact', 'This string should stay intact'],
            ['Null char should be replaced\u0000', 'Null char should be replaced\uFFFD'],
            ['don\'t change \u1243 \u5422 \u2222 \u1235 \u5676 \u0001', 'don\'t change \u1243 \u5422 \u2222 \u1235 \u5676 \u0001'],
        ];
    }

    /**
     * @dataProvider dpJsonStringsWithDifferentNewlineStyles
     *
     * @param string $json_string_input
     * @param string $json_string_expected
     */
    public function testEnsureOnlyLineFeedChars ($json_string_input, $json_string_expected)
    {
        $input = json_decode('"' . $json_string_input . '"');
        $expected_output = json_decode('"' . $json_string_expected . '"');

        $result = Sanitizer::ensureOnlyLineFeedChars($input);

        $this->assertTrue($expected_output === $result, "$expected_output should match $result");
    }

    public function dpJsonStringsWithDifferentNewlineStyles ()
    {
        return [
            ["No newlines at all", "No newlines at all"],
            ["Carriage return \r", "Carriage return \n"],
            ["Carriage return line feed \r\n", "Carriage return line feed \n"],
            ["Complex \r\r\n \r\n\r\r", "Complex \n\n \n\n\n"],
            ["\r\n\r\n\r\n\r\n\r\r\r\r\r\r\n\n", "\n\n\n\n\n\n\n\n\n\n\n"],
            ['Cariage Return \u000D', 'Cariage Return \u000A'],
            ['Line feed \u000A', 'Line feed \u000A'],
            ['Cariage return line feed \u000D\u000D\u000A', 'Cariage return line feed \u000A\u000A'],
            ['Complex \u000D\u000D\u000A\u000D\u000D', 'Complex \u000A\u000A\u000A\u000A'],
            ['Complex mix \u000D\u000D\u000A\u000D\u000D\n\r', 'Complex mix \u000A\u000A\u000A\u000A\n'],
        ];
    }
}