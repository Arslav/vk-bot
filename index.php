<?php

use Bot\App;
use Psr\Container\ContainerInterface;

/** @var ContainerInterface $container */
$container = require __DIR__ . '/bootstrap.php';
$argv = $argv ?? null;
$app = App::init($container, $argv);

$app->run();
