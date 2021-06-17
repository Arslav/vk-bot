<?php

namespace Bot\Commands;

use Bot\App;
use Bot\Base\VkCommand;

class BlyaCommand extends VkCommand
{
    /**
     * @var float
     */
    public $chance = 0.33;

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        if (checkChance($this->chance)) {
            $lya = $this->data->object->text;
            App::getVk()->reply('б' . $lya);
        }
    }
}