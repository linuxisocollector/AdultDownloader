<?php
namespace App\Downloaders;

use App\Helper\ProgressHelper;
use Cocur\BackgroundProcess\BackgroundProcess;
use Exception;

class Aria2 implements AbstractDownloader {
    /** @var \Aria2 */
    private $aria2;
    private $progressHelper;
    public function __construct(ProgressHelper $progressHelper)
    {
        $cmd = '/usr/bin/aria2c --enable-rpc --rpc-listen-port 6800';
        $outputfile = 'aria2.output';
        $pidfile = "look_pid";
        $process = exec(sprintf("%s > %s 2>&1 & echo $! >> %s", $cmd, $outputfile, $pidfile));
        $this->aria2 = new \Aria2('http://127.0.0.1:6800/jsonrpc'); 
        $this->progressHelper = $progressHelper;
        register_shutdown_function('App\Downloaders\Aria2::killprocess');
    }

    public static function killprocess() {
        posix_kill ((int)rtrim(file_get_contents('look_pid')), 0 );
        
    }

    public function downloadFile($url,$dir,$name) {
        $resp = $this->aria2->addUri(
            [$url],
            [
                'dir'=> $dir,
                'out'=> $name
        ],
        );
        //not async for the moment
        while(true) {
            $res = $this->aria2->tellStatus($resp['result'])['result'];
            if($res['status'] == 'active') {
                $current_file = $res['files'][0];
                if($current_file['length'] != 0 && $current_file['completedLength'] != 0) {
                    $percentage = $current_file['completedLength'] / $current_file['length']  * 100 ;
                } else {
                    $percentage = 0;
                }
                $this->progressHelper->AdvanceDownloadStatus($percentage, $this->formatSize($res['totalLength']));
            } else if($res['status'] == 'complete') {
                return true;
            } else {
                throw new Exception('Error downloading file');
            }
            sleep(1);
        }
    }
    function formatSize($bytes,$decimals=2){
        $size=array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
        $factor=floor((strlen($bytes)-1)/3);
        return sprintf("%.{$decimals}f",$bytes/pow(1024,$factor)).@$size[$factor];
    }
}