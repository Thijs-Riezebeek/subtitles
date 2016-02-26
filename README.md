ThijsR\Subtitles
================

This package contains the functionality to modify subtitle files. It is currently in a beta state and therefore names as wel as APIs can and probably will change.

Examples
--------

Below is a simple example of reading in an `.srt` file, delaying it by 3200 milliseconds and writing it to a new file.

```php
use \ThijsR\Subtitles\SubRip;

$subrip_file _= SubRip\Reader::readFile("path/to/srt/file.srt");
SubRip\Modifier::addDelayInMs($srt_file, 3200);
SubRip\Writer::writeFile($srt_file, "new/path/to/delayed/srt/file.srt");
```

