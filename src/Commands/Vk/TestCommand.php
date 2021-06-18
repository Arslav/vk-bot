<?php

namespace Bot\Commands\Vk;

use Bot\App;
use Bot\Commands\Vk\Base\VkCommand;
use DigitalStar\vk_api\VkApiException;

class TestCommand extends VkCommand
{
    /**
     * @inheritDoc
     * @throws VkApiException
     */
    public function run(): void
    {
        foreach ($this->args as $arg) {
            App::getVk()->reply($arg);
        }
    }
}