<?php

namespace Bot\Commands\Vk;

use Bot\App;
use Bot\Commands\Vk\Base\VkCommand;
use DigitalStar\vk_api\VkApiException;

class BlyaCommand extends VkCommand
{
    /**
     * @var float
     */
    public $chance = 0.3;

    /**
     * @inheritDoc
     * @throws VkApiException
     */
    public function run(): void
    {
        if (checkChance($this->chance)) {
            $lya = $this->message;
            App::getVk()->reply('б' . $lya);
        }
    }
}