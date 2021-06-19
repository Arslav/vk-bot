<?php

namespace Bot\Commands\Vk\Base;

use Bot\Commands\Command;

abstract class VkCommand extends Command
{
    /**
     * @var string
     */
    public $message;

    /**
     * @var string
     */
    public $peer_id;

    /**
     * @var string
     */
    public $from_id;

    /**
     * @var string
     */
    public $chat_id;

    //TODO: Параметр для отключения ^ $

    /**
     * @param mixed $args
     * @param mixed $data
     */
    public function init($data, $args) : void
    {
        $this->message = $data->object->text;
        $this->peer_id = $data->object->peer_id;
        $this->from_id = $data->object->from_id;
        //См. https://kotoff.net/article/31-vk-bot-poleznye-funkcii-komandy-dlja-bota-vk.html
        $this->chat_id = $data->object->peer_id - 2000000000;
        $this->args = $args;
    }

    /**
     * @return bool
     */
    public function isFromChat(): bool
    {
        //Если $chat_id > 0, то сообщение в беседе, если меньше, то ЛС.
        return $this->chat_id > 0;
    }

    public function __construct(array $aliases)
    {
        parent::__construct($aliases);
    }
}