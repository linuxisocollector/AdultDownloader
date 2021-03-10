<?php
namespace App\Helper;

class DirectoryHelper {
    private static $download_base_path = "";
    private static $folders = [
        'metadata',
        'videos',
        'cache',
        'logs'
    ];

    public function __construct($path)
    {
        self::$download_base_path = realpath($path);
    }
    /**
     * Returns html from cache
     *
     * @param [type] $url
     * @return void
     */
    public static function getCached($url) {
        $filepath  = DirectoryHelper::getRealPath('cache').md5($url);
        if(is_file($filepath)) {
            return file_get_contents($filepath);
        }
        return false;
    }



    public static function getRealPath($name) {
        if(!in_array($name,self::$folders)) {
            dump('Invalid Folder name '.$name);
            die();
        }
        return self::$download_base_path."/".$name."/";
    }

    public function deleteFromPath($path) {
        if(substr($path,-1,1) !== "/") {
            LoggerHelper::writeToConsole('Something went Wrong, this Path is not a folder','error');
        }
        array_map( 'unlink', array_filter((array) glob($path."*") ) );
    }
    /**
     * Creates the folder structure metadata html and videos
     *
     * @return void
     */
    public function setupFolder() {
        if(!is_dir(self::$download_base_path)) {
            mkdir(self::$download_base_path);
        }
        
        foreach (self::$folders as $key => $value) {
            $real_path = $this->getRealPath($value);
            if(!is_dir($real_path)) {
                mkdir($real_path);
                chmod($real_path,'777');
            }
        }
    }
}