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
    public $chance;

    /**
     * PressFCommand constructor.
     * @param array $aliases
     * @param int $limit
     * @param int $interval
     * @param float $chance
     */
    public function __construct(array $aliases, int $limit, int $interval, float $chance)
    {
        $this->chance = $chance;
        parent::__construct($aliases, $limit, $interval);
    }

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