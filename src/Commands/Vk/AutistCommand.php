<?php

namespace Bot\Commands\Vk;

use Bot\App;
use Bot\Commands\Vk\Base\LimitedVkCommand;
use DigitalStar\vk_api\VkApiException;

class AutistCommand extends LimitedVkCommand
{
    /**
     * @inheritDoc
     * @throws VkApiException
     */
    public function run(): void
    {
        App::getVk()->reply($this->message);
    }
}