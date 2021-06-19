<?php

use Bot\Commands\Cli\TestCommand;
use Bot\Commands\Vk\BlyaCommand;
use Bot\Commands\Vk\AutistCommand;
use Bot\Commands\Vk\GiveMePillsCommand;
use Bot\Commands\Vk\KickMeCommand;
use Bot\Commands\Vk\PressFCommand;
use Bot\Commands\Vk\WhoAmICommand;
use Bot\Commands\Vk\WhoWeCommand;
use Bot\Commands\Vk\WowSpecTopCommand;
use DigitalStar\vk_api\vk_api;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use function DI\autowire;
use function DI\create;
use function DI\get;

return [
    'LOG_LEVEL' => DI\env('LOG_LEVEL'),
    'DB_CONNECT_STRING' => DI\env('DB_CONNECT_STRING'),
    'ENVIRONMENT' => DI\env('ENVIRONMENT'),
    'VK_API_TOKEN' => DI\env('VK_API_TOKEN'),
    'VK_API_VERSION' => DI\env('VK_API_VERSION'),
    'VK_API_CONFIRM_STRING' => DI\env('VK_API_CONFIRM_STRING'),

    'isDev' => DI\factory(function ($c) {
        return $c->get('ENVIRONMENT') == 'dev';
    }),

    StreamHandler::class => DI\factory(function (ContainerInterface $c) {
        return new StreamHandler('app.log', $c->get('LOG_LEVEL'));
    }),

    Psr\Log\LoggerInterface::class => DI\factory(function (ContainerInterface $c) {
        $logger = new Logger('bot');
        $logger->pushHandler($c->get(StreamHandler::class));
        return $logger;
    }),

    Doctrine\ORM\Configuration::class => DI\factory(function (ContainerInterface $c) {
        $paths = ['src/Entities'];
        return Setup::createAnnotationMetadataConfiguration($paths, $c->get('isDev'));
    }),

    DriverManager::class => DI\factory(function (ContainerInterface $c) {
        return DriverManager::getConnection([
            'url' => $c->get('DB_CONNECT_STRING'),
            'charset' => 'UTF8',
        ]);
    }),

    EntityManager::class => DI\factory(function (ContainerInterface $c) {
        return EntityManager::create(
            $c->get(DriverManager::class),
            $c->get(Doctrine\ORM\Configuration::class)
        );
    }),

    vk_api::class => DI\factory(function (ContainerInterface $c) {
        $vk = vk_api::create($c->get('VK_API_TOKEN'), $c->get('VK_API_VERSION'))->setConfirm($c->get('VK_API_CONFIRM_STRING'));
        if ($c->get('isDev')) {
            $vk->debug();
        }
        return $vk;
    }),

    TestCommand::class => create(TestCommand::class)->constructor(['test']),

    'cli-commands' => [
        get(TestCommand::class),
    ],

    AutistCommand::class => autowire()
        ->constructorParameter('aliases',[
            '^ыы+$',
            '^кря+$',
            '^ря+$',
            '^[аы]{2,}$'
        ])
    ->property('limit', 20),

    BlyaCommand::class => autowire()
        ->constructorParameter('aliases', ['^ля+$']),

    GiveMePillsCommand::class => autowire()
        ->constructorParameter('aliases', ['сла+ва+(\,)? дай табле(тки+|то+к)\s?[(\!)(\?)]*$']),

    KickMeCommand::class => autowire()
        ->constructorParameter('aliases', ['^сла+ва+(\,)? не ки+ка+й\s?[(\!)(\?)]*$']),

    PressFCommand::class => autowire()
        ->constructorParameter('aliases', ['(.*\s|^)f([\.\!\?\,]|\s.*|$)']),

    WhoAmICommand::class => create()->constructor(['^сла+ва+(\,)? [кчх]то+ я\s?(\?)*$']),

    WhoWeCommand::class => create()->constructor(['^сла+ва+(\,)? [хк]то+ мы+\s?(\?)*$']),

    WowSpecTopCommand::class => create()->constructor(['^сла+ва+(\,)? [хк]то+ (сегодня\s)?топ\s?[(\!)(\?)]*$']),

    'vk-commands' => [
        get(AutistCommand::class),
        get(BlyaCommand::class),
        get(GiveMePillsCommand::class),
        get(KickMeCommand::class),
        get(PressFCommand::class),
        get(WhoAmICommand::class),
        get(WhoWeCommand::class),
        get(WowSpecTopCommand::class),
    ]
];

