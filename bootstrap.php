
<?php
require __DIR__.'/vendor/autoload.php';
use Symfony\Component\Console\Application;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array(__DIR__."/src/Entity");
$isDevMode = false;

// the connection configuration
$connectionParams = array(
    'url' => 'sqlite:///var/app.sqlite',
);

$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
$config = Setup::createAnnotationMetadataConfiguration($paths,true);
$entityManager = EntityManager::create($conn, $config);

