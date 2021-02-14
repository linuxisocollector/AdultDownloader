<?php
use Symfony\Component\Console\Application;

require_once 'bootstrap.php';
$application = new Application();


$application->add(new \App\Command\DownloadHookupHotShotCommand());
// ... register commands

$application->run();