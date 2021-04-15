<?php

use Bot\App;
use Bot\Commands\AutistCommand;
use Bot\Commands\GiveMePillsCommand;
use Bot\Commands\ImStupidCommand;
use Bot\Commands\WhoAmICommand;
use Bot\Commands\WhoWeCommand;

$container = require __DIR__ . '/bootstrap.php';

$app = App::init($container);

$app->add(new AutistCommand([
    '^ыы+$',
    '^кря+$',
    '^[аы]{2,}$',
]));
$app->add(new WhoAmICommand(['^сла+ва+(\,)? [кчх]то+ я\s?(\?)*$']));
$app->add(new WhoWeCommand(['^сла+ва+(\,)? [хк]то+ мы+\s?(\?)*$']));
$app->add(new GiveMePillsCommand(['сла+ва+(\,)? дай таблетки+\s?[(\!)(\?)]*$']));
$app->add(new ImStupidCommand(['^сла+ва+(\,)? я тупой']));

$app->run();