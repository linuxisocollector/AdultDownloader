#!/usr/bin/env php
<?php
use Symfony\Component\Console\Application;
use HaydenPierce\ClassFinder\ClassFinder;

require_once 'bootstrap.php';
$application = new Application();

$commandNamespaces = [
    'App\Command\Downloaders',
    'App\Command\Operations'
];
foreach ($commandNamespaces as $key => $value) {
    $classes = ClassFinder::getClassesInNamespace($value);
    foreach ($classes as $key => $command) {
        if($command == "App\Command\Downloaders\AbstractDownloadCommand") {
            continue;
        }
        $application->add(new $command());
    
    
    }
}

$application->run();