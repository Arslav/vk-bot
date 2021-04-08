<?php


namespace Bot\Commands;

use Bot\App;

class AutistCommand extends AbstractBaseCommand
{
    /**
     * @inheritDoc
     */
    public function action($data): void
    {
        App::getVk()->reply('ыыыы');
    }
}