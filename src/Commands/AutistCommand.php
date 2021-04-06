<?php


namespace Bot\Commands;

use Bot\App;

class AutistCommand extends BaseCommand
{
    public $aliases = ['ыыыы'];
    /**
     * @inheritDoc
     */
    public function action($data): void
    {
        App::$app->api->reply('ыыыы');
    }
}