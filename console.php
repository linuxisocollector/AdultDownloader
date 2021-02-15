#!/usr/bin/env php
<?php
use Symfony\Component\Console\Application;
use HaydenPierce\ClassFinder\ClassFinder;

require_once 'bootstrap.php';
$application = new Application();
$classes = ClassFinder::getClassesInNamespace('App\Command');
foreach ($classes as $key => $command) {
    if($command == "App\Command\AbstractDownloadCommand") {
        continue;
    }
    $application->add(new $command());


}

$application->run();