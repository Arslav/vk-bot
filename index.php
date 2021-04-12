<?php

use Bot\App;
use Bot\Commands\AutistCommand;
use Bot\Commands\WhoAmICommand;
use Bot\Commands\WhoWeCommand;

$container = require __DIR__ . '/bootstrap.php';


$app = App::init($container);

$app->add(new AutistCommand([
    '^ыы+$',
    '^кря+$',
    '^[аы]{2,}$',
]));
$app->add(new WhoAmICommand(['^слава+(\,)? [кчх]то я(\?)*$']));
$app->add(new WhoWeCommand(['^слава+(\,)? кто мы(\?)*$']));

$app->run();

