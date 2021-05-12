<?php

namespace Bot\Commands;

use Bot\App;
use Bot\Base\AbstractBaseCommand;

class BlyaCommand extends AbstractBaseCommand
{
    /**
     * @var float
     */
    public $chance = 0.33;

    /**
     * @inheritDoc
     */
    public function action($data): void
    {
        if(checkChance($this->chance)){
            $lya = $data->object->text;
            App::getVk()->reply('б'.$lya);
        }
    }
}