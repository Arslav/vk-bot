<?php

namespace Bot\Commands\Vk;

use Bot\App;
use Bot\Commands\Vk\Base\LimitedVkCommand;
use DigitalStar\vk_api\VkApiException;

class GiveMePillsCommand extends LimitedVkCommand
{
    /**
     * @inheritDoc
     * @throws VkApiException
     */
    public function run(): void
    {
        $pills = getFiles('/images/pills');
        if($pills) {
            App::getVk()->sendImage($this->peer_id,randomSelect($pills));
        } else {
            App::getVk()->reply('Таблетки кончились');
        }
    }
}

