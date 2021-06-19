<?php

use Dotenv\Dotenv;

require_once 'vendor/autoload.php';
require_once 'helpers.php';

$dotenv = Dotenv::createMutable(__DIR__);
$dotenv->load();

$builder = new DI\ContainerBuilder();
$builder->useAnnotations(true);
$builder->addDefinitions(__DIR__.'/config/container.php');
$builder->addDefinitions(__DIR__.'/config/cli-commands.php');
$builder->addDefinitions(__DIR__.'/config/vk-commands.php');


return $builder->build();
