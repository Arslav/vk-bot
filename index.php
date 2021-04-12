<?php

use Bot\App;
use Bot\Commands\AutistCommand;
use Bot\Commands\WhoAmICommand;

$container = require __DIR__ . '/bootstrap.php';


$app = App::init($container);

$app->add(new AutistCommand([
    '^ыы+$',
    '^кря$',
    '^[аы]{2,}$',
]));
$app->add(new WhoAmICommand(['^слава(\,)?\s*[кчх]то\s*я(\?)*$']));

$app->run();

