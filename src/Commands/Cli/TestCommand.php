<?php

namespace Bot\Commands\Cli;

use Bot\App;
use Bot\Commands\Cli\Base\CliCommand;
use DigitalStar\vk_api\VkApiException;

class TestCommand extends CliCommand
{
    /**
     * @throws VkApiException
     */
    public function run(): int
    {
        echo $this->args[1].PHP_EOL;
        echo $this->args[2].PHP_EOL;
        App::getVk()->sendMessage($this->args[1], $this->args[2]);
        return 0;
    }
}