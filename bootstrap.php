<?php

use Dotenv\Dotenv;

require_once 'vendor/autoload.php';
require_once 'helpers.php';

$dotenv = Dotenv::createMutable(__DIR__);
$dotenv->load();

$builder = new DI\ContainerBuilder();
$builder->addDefinitions(__DIR__.'/config/container.php');

return $builder->build();
