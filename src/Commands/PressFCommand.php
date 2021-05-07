<?php

namespace Bot\Commands;

use Bot\App;
use Bot\Base\AbstractBaseCommand;
use Bot\Commands\Traits\CooldownTrait;
use DigitalStar\vk_api\VkApiException;

class PressFCommand extends AbstractBaseCommand
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
     * @var float
     */
    public $chance = 0.1;

    /**
     * @inheritDoc
     * @throws VkApiException
     */
    public function action($data): void
    {
        $send_picture = checkChance($this->chance);
        $f_pictures = getFiles('/images/f');
        if($send_picture && $f_pictures) {
            App::getVk()->sendImage($data->object->peer_id,randomSelect($f_pictures));
        }else{
            App::getVk()->reply('F');
        }
    }
}