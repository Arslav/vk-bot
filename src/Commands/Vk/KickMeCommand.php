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
    public $chance;

    /**
     * KickMeCommand constructor.
     * @param array $aliases
     * @param float $chance
     */
    public function __construct(array $aliases, float $chance)
    {
        $this->chance = $chance;
        parent::__construct($aliases);
    }

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