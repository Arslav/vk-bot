<?php

namespace Bot;

use Bot\Base\AbstractBaseCommand;
use DigitalStar\vk_api\vk_api;
use Doctrine\ORM\EntityManager;
use Exception;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class App
{
    /**
     * @var App
     */
    private static $app;

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
    public static function init(ContainerInterface $container) : App
    {
        if (self::$app === null) {
            self::$app = new App();
            self::$container = $container;
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
        return self::$container->get(LoggerInterface::class);
    }

    /**
     * @return vk_api
     */
    public static function getVk(): vk_api
    {
        return self::$container->get(vk_api::class);
    }

    /**
     * @return EntityManager
     */
    public static function getEntityManager() : EntityManager
    {
        return self::$container->get(EntityManager::class);
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
        self::getLogger()->info('App started');
        try {
            $data = self::getVk()->initVars($id, $message);
            if ($data != null) {
                self::getLogger()->debug('Received data: ' . print_r($data, true));

                if ($data->type == 'message_new') {
                    self::getLogger()->info('New message: '. print_r($message, true));
                    $message = $data->object->text;
                    /** @var AbstractBaseCommand $command */
                    foreach ($this->commands as $command) {
                        foreach ($command->aliases as $alias) {
                            if (preg_match('/'.$alias.'/ui', $message)) {
                                self::getLogger()->info('Command started: ' . $message);
                                $command->action($data);
                                self::getLogger()->info('Command ended');
                                break;
                            }
                        }
                    }
                }
            }
        }
        catch (Exception $e) //TODO: раскидать по типам исключений
        {
            self::getLogger()->error($e->getMessage());
        }
        self::getLogger()->info('App ended');
    }
}