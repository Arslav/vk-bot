<?php

use Dotenv\Dotenv;

require_once 'vendor/autoload.php';

define('LOG_LEVEL', $_ENV['LOG_LEVEL']);
define('VK_API_TOKEN', $_ENV['VK_API_TOKEN']);
define('VK_API_VERSION', $_ENV['VK_API_VERSION']);
define('VK_API_CONFIRM_STRING', $_ENV['VK_API_CONFIRM_STRING']);

$dotenv = Dotenv::createMutable(__DIR__);
$dotenv->load();

$builder = new DI\ContainerBuilder();
$builder->addDefinitions(__DIR__.'/config/services.php');

return $builder->build();
