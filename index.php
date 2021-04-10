<?php

use Bot\App;
use Bot\Commands\AutistCommand;
use Bot\Commands\WhoAmICommand;

$container = require __DIR__.'/bootstrap.php';


$app = App::init($container);

$app->add(new AutistCommand(['ыыыы', 'кря', 'аыаыаы']));
$app->add(new WhoAmICommand(['слава, кто я?', 'слава кто я', 'слава что я', 'слава, что я?', 'слава, кто я', 'слава, что я']));

$app->run();

