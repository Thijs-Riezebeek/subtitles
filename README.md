Subtitle File Modification
==========================

This package contains the functionality to modify subtitle files. It is currently in a beta state and therefore names as wel as APIs can and probably will change.

Functionality
-------------

* Delaying all subtitles in a file
* Fixing a 'broken' subtitle file by restoring the numbering. 

Installation
------------

The package can be installed using the following command:

```bash
composer require thijsr/subtitles
```

Or by adding it to your `composer.json` manually:

```json
"require": {
  "thijsr/subtitles": ">=1.0.0-beta
}
```

Examples
--------

Below is a simple example of reading in a `.srt` file, delaying it by 3200 milliseconds and writing it to a new file.

```php
use \ThijsR\Subtitles\SubRip;

$subrip_file _= SubRip\Reader::readFile("path/to/srt/file.srt");
SubRip\Modifier::addDelayInMs($srt_file, 3200);
SubRip\Writer::writeFile($srt_file, "new/path/to/delayed/srt/file.srt");
```

Sometimes `srt` files cannot be opened in Media Players because the numbering is not correct. This example shows a fix for this.

```php
use \ThijsR\Subtitles\SubRip;

$subrip_file _= SubRip\Reader::readFile("path/to/srt/file.srt");
SubRip\Modifier::restoreNumbering($subrip_file);
SubRip\Writer::writeFile($srt_file, "new/path/to/delayed/srt/file.srt");
```
