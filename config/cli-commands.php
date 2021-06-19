<?php

use Bot\Commands\Cli\SendMessageCommand;
use function DI\create;
use function DI\get;

return [
    SendMessageCommand::class => create(SendMessageCommand::class)->constructor(['send']),

    'cli-commands' => [
        get(SendMessageCommand::class),
    ],
];