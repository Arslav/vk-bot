<?php


namespace Bot\Commands;

use Bot\App;
use Bot\Base\AbstractBaseCommand;
use Bot\Commands\Traits\CooldownTrait;
use DigitalStar\vk_api\VkApiException;

class AutistCommand extends AbstractBaseCommand
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
    public function action($data): void
    {
        App::getVk()->reply($data->object->text);
    }
}