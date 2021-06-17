<?php

namespace Bot;

use Bot\Base\BaseCommand;
use Bot\Base\CliCommand;
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
     * @param array $args
     * @return App
     */
    public static function init(ContainerInterface $container, array $args) : App
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
//        self::getLogger()->info('App started');
//        try {
//            $data = self::getVk()->initVars($id, $message);
//            if ($data != null) {
//                self::getLogger()->debug('Received data: ' . print_r($data, true));
//
//                if ($data->type == 'message_new') {
//                    self::getLogger()->info('New message: '. print_r($message, true));
//                    $message = $data->object->text;
//                    /** @var BaseCommand $command */
//                    foreach ($this->commands as $command) {
//                        foreach ($command->aliases as $alias) {
//                            if (preg_match('/'.$alias.'/ui', $message)) {
//                                self::getLogger()->info('Command started: ' . get_class($command));
//                                self::getLogger()->info('Before action started');
//                                $beforeResult = $command->beforeAction($data);
//                                self::getLogger()->debug('Before action returned: '.print_r($beforeResult,true));
//                                if($beforeResult){
//                                    self::getLogger()->info('Main action started');
//                                    $command->run($data);
//                                }
//                                self::getLogger()->info('Command ended');
//                                break;
//                            }
//                        }
//                    }
//                }
//            }
//        }
//        catch (Exception $e) //TODO: раскидать по типам исключений
//        {
//            self::getLogger()->error($e->getMessage());
//        }
//        self::getLogger()->info('App ended');
        if(self::IsCli()){
            $commands = self::$container->get('cli-commands');
            /** @var CliCommand $command */
            foreach ($commands as $command) {
                if(in_array(self::$args[1], $command->aliases)) {
                    $command->run();
                }
            }
        }
    }

}