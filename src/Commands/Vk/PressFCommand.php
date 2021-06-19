<?php

namespace Bot\Commands\Vk;

use Bot\App;
use Bot\Commands\Vk\Base\LimitedVkCommand;
use DigitalStar\vk_api\VkApiException;

class PressFCommand extends LimitedVkCommand
{
    /**
     * @var float
     */
    public $chance = 0.5;

    /**
     * @inheritDoc
     * @throws VkApiException
     */
    public function run()
    {
        $send_picture = checkChance($this->chance);
        $f_pictures = getFiles('/images/f');
        if($send_picture && $f_pictures) {
            App::getVk()->sendImage($this->peer_id,randomSelect($f_pictures));
        }else{
            App::getVk()->reply('F');
        }
    }
}