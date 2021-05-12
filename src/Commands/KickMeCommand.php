<?php


namespace Bot\Commands;


use Bot\App;
use Bot\Base\AbstractBaseCommand;
use DigitalStar\vk_api\VkApiException;

class KickMeCommand extends AbstractBaseCommand
{
    /**
     * @float
     */
    public $chance = 0.5;

    /**
     * @inheritDoc
     * @throws VkApiException
     */
    public function action($data): void
    {
        $chat_id = $data->object->peer_id - 2000000000; //Если $chat_id > 0, то сообщение в беседе, если меньше, то ЛС. см. https://kotoff.net/article/31-vk-bot-poleznye-funkcii-komandy-dlja-bota-vk.html
        if($chat_id > 0 && checkChance($this->chance)) {
            App::getVk()->reply('%a_fn% бан.');
            App::getVk()->request('messages.removeChatUser', [
                'chat_id' => $chat_id,
                'user_id' => $data->object->from_id
            ]);
        }
    }
}