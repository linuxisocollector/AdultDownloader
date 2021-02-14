<?php
namespace App\Helper;

class DirectoryHelper {
    private $download_base_path = "";
    private $folders = [
        'metadata',
        'videos',
        'cache',
        'logs'
    ];

    public function __construct($path)
    {
        $this->download_base_path = realpath($path);
    }


    public function getRealPath($name) {
        if(!in_array($name,$this->folders)) {
            dump('Invalid Folder name '.$name);
            die();
        }
        return $this->download_base_path."/".$name."/";
    }
    /**
     * Creates the folder structure metadata html and videos
     *
     * @return void
     */
    public function setup_folder() {
        if(!is_dir($this->download_base_path)) {
            mkdir($this->download_base_path);
        }
        
        foreach ($this->folders as $key => $value) {
            $real_path = $this->getRealPath($value);
            if(!is_dir($real_path)) {
                mkdir($real_path);
                chmod($real_path,'777');
            }
        }
    }
}