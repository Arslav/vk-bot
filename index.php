<?php

use Bot\App;
use Bot\Base\BaseCommand;
use Bot\Commands\AutistCommand;
use Bot\Commands\BlyaCommand;
use Bot\Commands\GiveMePillsCommand;
use Bot\Commands\KickMeCommand;
use Bot\Commands\PressFCommand;
use Bot\Commands\WhoAmICommand;
use Bot\Commands\WhoWeCommand;
use Bot\Commands\WowSpecTopCommand;
use Psr\Container\ContainerInterface;




//Тест
/** @var ContainerInterface $container */
$container = require __DIR__ . '/bootstrap.php';
$app = App::init($container, $argv);
$app->run();
die;
var_dump($argv[1]);
$app = App::init($container, $argv);
echo App::getEnvironment().PHP_EOL;
echo App::IsCli().PHP_EOL;
echo App::getArgs().PHP_EOL;
echo $container->get('cli-commands')[0]->run();

die;

//Парсинг аргументов и префиксов
$str = $argv[1];
// Склеика регулярОЧКи
$prefix = "^сла+ва+(\,)?";
$command = "не ки+ка+й\s?[(\!)(\?)]* <args>$";
$regex = "$prefix $command";
$regex = str_replace('<args>', '(?<args>.*)', $regex);
$regex = "/$regex/ui";
// Типо обработка
echo "Final regex: ".$regex.PHP_EOL;
echo 'Command detected: '.preg_match($regex, $str, $matches).PHP_EOL;
$args_str = $matches['args'];
echo 'Args: '.PHP_EOL;
var_dump(str_split($args_str));
die;
$container = require __DIR__ . '/bootstrap.php';

$app = App::init($container);

$app->add(new AutistCommand([
    '^ыы+$',
    '^кря+$',
    '^ря+$',
    '^[аы]{2,}$',
]));
$app->add(new KickMeCommand(['^сла+ва+(\,)? не ки+ка+й\s?[(\!)(\?)]*$']));
$app->add(new BlyaCommand(['^ля+$']));
$app->add(new WhoAmICommand(['^сла+ва+(\,)? [кчх]то+ я\s?(\?)*$']));
$app->add(new WhoWeCommand(['^сла+ва+(\,)? [хк]то+ мы+\s?(\?)*$']));
$app->add(new GiveMePillsCommand(['сла+ва+(\,)? дай табле(тки+|то+к)\s?[(\!)(\?)]*$']));
$app->add(new PressFCommand(['(.*\s|^)f([\.\!\?\,]|\s.*|$)']));
$app->add(new WowSpecTopCommand(['^сла+ва+(\,)? [хк]то+ (сегодня\s)?топ\s?[(\!)(\?)]*$']));

$app->run();