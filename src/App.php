<?php

namespace Bot;

use Bot\Commands\BaseCommand;
use DigitalStar\vk_api\vk_api;
use Psr\Log\LoggerInterface;

class App
{
    /**
     * @var App
     */
    public static $app;

    /**
     * @var LoggerInterface
     */
    public $logger;

    /**
     * @var vk_api
     */
    public $api;

    /**
     * @var array
     */
    private $commands = [];


    /**
     * App constructor
     * @param LoggerInterface $logger
     * @param vk_api $api
     */
    public function __construct(LoggerInterface $logger, vk_api $api)
    {
        $this->logger = $logger;
        $this->api = $api;
        App::$app = $this;
    }

    /**
     * @param BaseCommand $command
     */
    public function add(BaseCommand $command) : void
    {
        $this->commands[] = $command;
    }

    /**
     * Run App
     */
    public function run() : void
    {
        $this->logger->info('App started');
        $data = $this->api->initVars();
        $this->logger->debug('Received data', $data);

        if($data->type == 'message_new') {
            $this->logger->info('New message');

            /** @var BaseCommand $command */
            foreach ($this->commands as $command){
                $message = mb_strtolower($data->object->text);
                if(in_array($message, $command->aliases)){
                    $this->logger->info('Command started: '.$message);
                    $command->action($data);
                }
            }
        }
        $this->logger->info('App ended');
    }
}