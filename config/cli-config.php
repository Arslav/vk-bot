<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Configuration\Connection\ExistingConnection;
use Doctrine\Migrations\Configuration\Migration\ExistingConfiguration;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Metadata\Storage\TableMetadataStorageConfiguration;
use Doctrine\Migrations\Provider\OrmSchemaProvider;
use Doctrine\Migrations\Provider\SchemaProvider;
use Doctrine\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\Migrations\Tools\Console\Command\DumpSchemaCommand;
use Doctrine\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\Migrations\Tools\Console\Command\LatestCommand;
use Doctrine\Migrations\Tools\Console\Command\ListCommand;
use Doctrine\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\Migrations\Tools\Console\Command\RollupCommand;
use Doctrine\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\Migrations\Tools\Console\Command\SyncMetadataCommand;
use Doctrine\Migrations\Tools\Console\Command\VersionCommand;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$container = require 'bootstrap.php';

$entityManager = $container->get(EntityManager::class);
$connection = $container->get(DriverManager::class);

$configuration = new Configuration($connection);
$configuration->addMigrationsDirectory('Bot\Migrations', 'src/Migrations');
$configuration->setAllOrNothing(true);
$configuration->setCheckDatabasePlatform(false);

$storageConfiguration = new TableMetadataStorageConfiguration();
$storageConfiguration->setTableName('doctrine_migration_versions');

$configuration->setMetadataStorageConfiguration($storageConfiguration);

$di = DependencyFactory::fromConnection(
    new ExistingConfiguration($configuration),
    new ExistingConnection($connection)
);
$di->setService(SchemaProvider::class, new OrmSchemaProvider($entityManager));

$helperSet = ConsoleRunner::createHelperSet($entityManager);
$cli = ConsoleRunner::createApplication($helperSet, [
    new DumpSchemaCommand($di),
    new ExecuteCommand($di),
    new GenerateCommand($di),
    new LatestCommand($di),
    new ListCommand($di),
    new MigrateCommand($di),
    new RollupCommand($di),
    new StatusCommand($di),
    new SyncMetadataCommand($di),
    new VersionCommand($di),
    new DiffCommand($di)
]);

$cli->run();