<?php

use Bot\App;
use Bot\Commands\AutistCommand;
use Bot\Commands\WhoAmICommand;

$container = require __DIR__ . '/bootstrap.php';


$app = App::init($container);

$app->add(new AutistCommand([
    '/^ыыы+$/',
    '/^кря$/',
    '/^(аы)+$/',
]));
$app->add(new WhoAmICommand(['/^слава(\,)?\s*[к,ч,х]то\s*я(\?)*$/']));

$app->run();

