<?php

namespace Bot;

use Bot\Commands\Cli\Base\CliCommand;
use Bot\Commands\Vk\Base\VkCommand;
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
     * @var string
     */
    private static $environment;

    /**
     * @var array
     */
    private static $args;


    /**
     * App constructor.
     */
    private function __construct() {}

    /**
     * @param ContainerInterface $container
     * @param array | null $args
     * @return App
     */
    public static function init(ContainerInterface $container, ?array $args) : App
    {

        if (self::$app === null) {
            self::$app = new App();
            self::$container = $container;
            self::$environment = php_sapi_name();
            self::$args = $args;
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
     * @return string
     */
    public static function getEnvironment(): string
    {
        return self::$environment;
    }

    public static function IsCli(): bool
    {
        return self::$environment == 'cli';
    }

    /**
     * @return array
     */
    public static function getArgs(): array
    {
        return self::$args;
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

//    /**
//     * @param BaseCommand $command
//     */
//    public function add(BaseCommand $command) : void
//    {
//        $this->commands[] = $command;
//    }

    /**
     * Run App
     */
    public function run() : void
    {
        self::getLogger()->info('App started');
        if(self::IsCli()){
            $this->executeCli();
        }
        $this->exucuteVk();
        self::getLogger()->info('App ended');
    }

    private function executeCli()
    {
        self::getLogger()->info('Runned from CLI');
        $commands = self::$container->get('cli-commands');
        /** @var CliCommand $command */
        foreach ($commands as $command) {
            $status = 0;
            if(in_array(self::$args[1], $command->aliases)) {
                if($command->beforeAction()){
                    $status = $command->run();
                }
            }
            exit($status);
        }
    }

    private function exucuteVk()
    {
        self::getLogger()->info('Runned from VK');
        $commands = self::$container->get('vk-commands');
        $data = self::getVk()->initVars($id, $message);
        self::getLogger()->debug('Received data: ' . print_r($data, true));
        if($data != null) {
            //TODO: Разделить команды по типу триггеров! message_new и т.д.!!!
            if ($data->type == 'message_new') {
                self::getLogger()->info('New message: '. print_r($message, true));
                $message = $data->object->text;
                /** @var VkCommand $command */
                foreach ($commands as $command) {
                    foreach ($command->aliases as $alias) {
                        //TODO: Подумать на тему префиксов
                        $regex = str_replace('<args>', '(?<args>.*)', $alias);
                        $regex = "/$regex/ui";
                        if (preg_match($regex, $message, $matches)) {
                            self::getLogger()->debug($regex);
                            self::getLogger()->info('Command detected: ' . get_class($command));
                            $args = $matches['args'] ?? null;
                            self::getLogger()->debug('Parsed Args: ' . print_r($args, true));
                            $command->init($data, $args);
                            if($command->beforeAction()) {
                                $status = 'ok';
                                $status = $command->run();
                                self::getLogger()->info("Command executed with status: $status");
                            }
                        }
                    }
                }
            }
        }
    }

}