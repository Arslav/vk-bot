<?php


namespace Bot\Commands;

use Bot\App;

class AutistCommand extends BaseCommand
{
    /**
     * @inheritDoc
     */
    public function action($data): void
    {
        App::$app->api->reply('ыыыы');
    }
}