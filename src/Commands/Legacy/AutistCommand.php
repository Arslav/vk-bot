<?php

namespace Bot\Commands;

use Bot\App;
use Bot\Base\VkCommand;
use Bot\Commands\Traits\CooldownTrait;
use DigitalStar\vk_api\VkApiException;

class AutistCommand extends VkCommand
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
    public function run(): void
    {
        App::getVk()->reply($this->data->object->text);
    }
}