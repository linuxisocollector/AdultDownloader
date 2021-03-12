<?php
namespace App\Helper;

use App\Command\Downloaders\AbstractDownloadCommand;
use HaydenPierce\ClassFinder\ClassFinder;

class EntityManager {

    /**
     * Undocumented function
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public static function get() {
        global $entityManager;
        return $entityManager;
    }

    /**
     * Undocumented function
     *
     * @param String $downloadername
     * @return AbstractDownloadCommand|false
     */
    public static function getDownloadClassByName($downloadername) {
        $classes = ClassFinder::getClassesInNamespace('App\Command\Downloaders');
        $download_classes = [];
        foreach ($classes as $key => $class) {
            if($class == "App\Command\Downloaders\AbstractDownloadCommand") {
                continue;
            }
            $download_classes[$class::getPageName()] = $class;

        }
        if(!array_key_exists($downloadername,$download_classes)) {
            $sites = implode(', ',array_keys($download_classes));
            LoggerHelper::writeToConsole("$downloadername is not a valid page name use one of this options: $sites",'error');
            return false;
            
        }
        
        /** @var AbstractDownloadCommand */
        $download_class = new $download_classes[$downloadername]();
    }
}