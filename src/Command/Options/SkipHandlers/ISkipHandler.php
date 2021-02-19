<?php
namespace App\Command\Options\SkipHandlers;

Interface ISkipHandler {


    /**
     * Undocumented function
     *
     * @param Video[] $videos
     * @param String $argument
     */
    public function __construct($videos,$argument);

    /**
     * Undocumented function
     *
     * @return Video[]
     */
    public function action();

    /**
     * Undocumented function
     *
     * @return String
     */
    public static function getCommandName();

    public function doesHandle();

} 