<?php
namespace App\Helper;
class LoggerHelper {
    private static $io;
    public static function setIO($io) {
        self::$io = $io;
    }
    
    public static function getIO() {
        return self::$io;
    }

    /**
     * Log to console function
     *
     * @param [type] $text
     * @param [type] $log_level (info|error)
     * @return void
     */
    public static function writeToConsole($text,$log_level) {
        if($log_level == 'info') {
            $text = '<info>'.$text.'</info>';
        }
        if($log_level == 'error') {
            $text = '<error>'.$text.'</error>';

        }
        self::$io->writeln($text);
    }
}