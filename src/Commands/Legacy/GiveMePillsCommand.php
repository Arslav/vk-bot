<?php

namespace Bot\Commands;

use Bot\App;
use Bot\Base\Command;
use Bot\Commands\Traits\CooldownTrait;
use DigitalStar\vk_api\VkApiException;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\Finder;

class GiveMePillsCommand extends Command
{
    use CooldownTrait;

    /**
     * @param $data
     * @return bool
     */
    public function beforeAction($data): bool
    {
        return $this->checkCooldown($data->object->peer_id);
    }

    /**
     * @inheritDoc
     * @throws VkApiException
     */
    public function run($data): void
    {
        $pills = getFiles('/images/pills');
        if($pills) {
            App::getVk()->sendImage($data->object->peer_id,randomSelect($pills));
        } else {
            App::getVk()->reply('Таблетки кончились');
        }
    }
}

