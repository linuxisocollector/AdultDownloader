<?php

namespace App\Helper;
/**
 * @see https://trac.opensubtitles.org/projects/opensubtitles/wiki/HashSourceCodes
 * doesnt work anymore with PHP 7 so were using the bash algorithm
 */
class Ohash
{
    public static function OpenSubtitlesHash($path) {
        setlocale(LC_CTYPE, "en_US.UTF-8");
        $path = escapeshellarg($path);
        $out = shell_exec("osdb hash $path ");
        $out_arr =explode(':',$out);
        $out = trim(end($out_arr));
        if($out == 'no such file or directory') {
            LoggerHelper::writeToConsole("File not found: $path",'error');
        }
        return $out;
    }
}
