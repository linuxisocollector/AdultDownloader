<?php
namespace App\Downloaders;

use App\Helper\CookieHelper;
use App\Helper\LoggerHelper;
use App\Helper\ProgressHelper;

class Streamlink implements AbstractDownloader, ICookie{
    private ProgressHelper $progressHelper;

    public function __construct(ProgressHelper $progressHelper) { 
        $this->progressHelper = $progressHelper;
    }

    public function setCookies(CookieHelper $cookies) {
        //@todo Implement this function
    }

    public function __destruct()
    {
        \posix_kill ((int)rtrim(file_get_contents('lock_pid')), 0 );
    }

    public function downloadFile($url, $dir, $name) {
        $cmd = 'streamlink "'.$url.'" best --force --stream-segment-threads 8 -o "'.$dir.$name.'"';
        $outputfile = 'streamlink.output';
        $pidfile = "lock_pid";
        $process = exec(sprintf("%s > %s 2>&1 & echo $! > %s", $cmd, $outputfile, $pidfile));
        $pid = (int)file_get_contents($pidfile);
        $last_modify_time = 0;
        $old_str = "";
        while(\posix_getpgid($pid) !== false) {
            clearstatcache(true, $outputfile);
            $curr_modify_time = filemtime($outputfile);
            if ($last_modify_time < $curr_modify_time) {
                $new_log = file_get_contents($outputfile);
                LoggerHelper::writeToConsole(str_replace($old_str, "", $new_log),'info');
                $old_str = $new_log;
            }
            $last_modify_time = $curr_modify_time;            
            sleep(1);
        }
    }
    
}