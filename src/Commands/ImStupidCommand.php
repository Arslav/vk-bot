<?php

namespace Bot\Commands;

use Bot\App;
use Bot\Base\AbstractBaseCommand;

class ImStupidCommand extends AbstractBaseCommand
{
    /**
     * @inheritDoc
     */
    public function action($data): void
    {
        $vk = App::getVk();
        $vk->sendButton($data->object->peer_id, 'Держи мой тупенький:', [
            $vk->buttonText('Слава, кто я?', 'green'),
            $vk->buttonText('Слава, кто мы?', 'white'),
            $vk->buttonText('Слава, дай таблеток', 'blue'),
            $vk->buttonText('ыыыыы', 'red'),
        ],true,true);
    }
}