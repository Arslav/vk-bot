<?php

use Bot\App;
use Bot\Commands\AutistCommand;
use Bot\Commands\BlyaCommand;
use Bot\Commands\GiveMePillsCommand;
use Bot\Commands\KickMeCommand;
use Bot\Commands\PressFCommand;
use Bot\Commands\WhoAmICommand;
use Bot\Commands\WhoWeCommand;
use Bot\Commands\WowSpecTopCommand;

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