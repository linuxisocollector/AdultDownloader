<?php
namespace App\Helper;

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
}