<?php

namespace App\Helper;
/**
 * @see https://trac.opensubtitles.org/projects/opensubtitles/wiki/HashSourceCodes
 * doesnt work anymore with PHP 7 so were using the bash algorithm
 */
class Ohash
{
    public static function OpenSubtitlesHash($path) {
        $path = escapeshellarg($path);
        return trim(shell_exec("bash ".__DIR__."/ohash.bash $path 2>/dev/null"));
    }
}
