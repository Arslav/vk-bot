<?php

namespace Bot;

use Bot\Commands\AbstractBaseCommand;
use DigitalStar\vk_api\vk_api;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class App
{
    /**
     * @var App
     */
    private static $app;

    /**
     * @var LoggerInterface
     */
    private static $logger;

    /**
     * @var vk_api
     */
    private static $vk;

    /**
     * @var ContainerInterface
     */
    private static $container;

    /**
     * @var array
     */
    private $commands = [];

    /**
     * App constructor.
     */
    private function __construct() {}

    /**
     * @param ContainerInterface $container
     * @return App
     */
    public static function create(ContainerInterface $container) : App
    {
        if (self::$app === null) {
            self::$app = new App();
            self::$container = $container;
            self::$vk = $container->get(vk_api::class);
            self::$logger = $container->get(LoggerInterface::class);
        }
        return self::$app;
    }

    /**
     * @return App
     */
    public static function getInstance(): App
    {
        return self::$app;
    }

    /**
     * @return LoggerInterface
     */
    public static function getLogger(): LoggerInterface
    {
        return self::$logger;
    }

    /**
     * @return vk_api
     */
    public static function getVk(): vk_api
    {
        return self::$vk;
    }

    /**
     * @return ContainerInterface
     */
    public static function getContainer(): ContainerInterface
    {
        return self::$container;
    }

    /**
     * @param AbstractBaseCommand $command
     */
    public function add(AbstractBaseCommand $command) : void
    {
        $this->commands[] = $command;
    }

    /**
     * Run App
     */
    public function run() : void
    {
        //TODO: Добавить перехват и логирование исключений
        self::$logger->info('App started');
        $data = self::$vk->initVars($id, $message);
        if($data != null) {
            self::$logger->debug('Received data: ' . print_r($data, true));

            if ($data->type == 'message_new') {
                self::$logger->info('New message');

                /** @var AbstractBaseCommand $command */
                foreach ($this->commands as $command) {
                    $message = mb_strtolower($data->object->text);
                    if (in_array($message, $command->aliases)) {
                        self::$logger->info('Command started: ' . $message);
                        $command->action($data);
                    }
                }
            }
        }
        self::$logger->info('App ended');
    }
}