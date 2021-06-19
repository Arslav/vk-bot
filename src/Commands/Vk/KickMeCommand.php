<?php

namespace Bot\Commands\Vk;

use Bot\App;
use Bot\Commands\Vk\Base\VkCommand;
use DigitalStar\vk_api\VkApiException;

class KickMeCommand extends VkCommand
{
    /**
     * @var float
     */
    public $chance = 0.5;

    /**
     *
     * @throws VkApiException
     */
    public function run(): void
    {
        if($this->isFromChat() && checkChance($this->chance)) {
            App::getVk()->reply('%a_fn% бан.');
            App::getVk()->request('messages.removeChatUser', [
                'chat_id' => $this->chat_id,
                'user_id' => $this->from_id
            ]);
        }
    }
}