<?php
// bootstrap.php
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;

require_once __DIR__ . '/../vendor/autoload.php';

// Configura la conexión y el EntityManager
$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . '/Entity'],
    isDevMode: true,
);

$connection = DriverManager::getConnection([
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/db.sqlite',
], $config);

$entityManager = new EntityManager($connection, $config);

// Crear el esquema si no existe
$schemaTool = new SchemaTool($entityManager);
$metadata = $entityManager->getMetadataFactory()->getAllMetadata();

if (!empty($metadata)) {
    // Actualiza el esquema (crea las tablas si no existen)
    $schemaTool->updateSchema($metadata); // true para suprimir la salida SQL
}

return $entityManager;
