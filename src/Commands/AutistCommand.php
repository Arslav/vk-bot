<?php


namespace Bot\Commands;

use Bot\App;
use Bot\Base\AbstractBaseCommand;
use DigitalStar\vk_api\VkApiException;

class AutistCommand extends AbstractBaseCommand
{
    /**
     * @inheritDoc
     * @throws VkApiException
     */
    public function action($data): void
    {
        App::getVk()->reply($data->object->text);
    }
}