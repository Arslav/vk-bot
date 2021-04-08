<?php

use Bot\App;
use Bot\Commands\AutistCommand;
use Bot\Commands\WhoAmICommand;
use DigitalStar\vk_api\vk_api;
use Dotenv\Dotenv;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

define('LOG_LEVEL', $_ENV['LOG_LEVEL']);
define('VK_API_TOKEN', $_ENV['VK_API_TOKEN']);
define('VK_API_VERSION', $_ENV['VK_API_VERSION']);
define('VK_API_CONFIRM_STRING', $_ENV['VK_API_CONFIRM_STRING']);

$logger = new Logger('bot');
$logger->pushHandler(new StreamHandler('app.log', LOG_LEVEL));

$vk = vk_api::create(VK_API_TOKEN, VK_API_VERSION)->setConfirm(VK_API_CONFIRM_STRING);

$app = new App($logger, $vk);

$app->add(new AutistCommand(['ыыыы', 'кря', 'аыаыаы']));
$app->add(new WhoAmICommand(['слава, кто я?', 'слава кто я', 'слава что я', 'слава, что я?', 'слава, кто я', 'слава, что я']));

$app->run();
