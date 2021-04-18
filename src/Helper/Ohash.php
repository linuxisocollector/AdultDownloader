<?php

namespace App\Helper;

/**
 * @see https://trac.opensubtitles.org/projects/opensubtitles/wiki/HashSourceCodes
 * doesnt work anymore with PHP 7 so were using the bash algorithm
 */
class Ohash
{
    public static function mb_escapeshellarg($arg)
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return '"' . str_replace(array('"', '%'), array('', ''), $arg) . '"';
        } else {
            return "'" . str_replace("'", "'\\''", $arg) . "'";
        }
    }

    public static function OpenSubtitlesHash($path)
    {
        $path = self::mb_escapeshellarg($path);
        $out = shell_exec("osdb hash $path");
        $out_arr = explode(':', $out);
        $out = trim(end($out_arr));
        if ($out == 'no such file or directory') {
            LoggerHelper::writeToConsole("File not found: $path", 'error');
        }
        $out = str_pad($out,16,"0",STR_PAD_LEFT);
        return $out;
    }
}
