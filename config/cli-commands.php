<?php

use Bot\Commands\Cli\CheckBirthdayCommand;
use Bot\Commands\Cli\ConversationsListCommand;
use Bot\Commands\Cli\SendMessageCommand;
use function DI\create;
use function DI\get;

return [
    SendMessageCommand::class => create()->constructor(['send']),
    CheckBirthdayCommand::class => create()->constructor(['birthday']),
    ConversationsListCommand::class => create()->constructor(['clist']),

    'cli-commands' => [
        get(SendMessageCommand::class),
        get(CheckBirthdayCommand::class),
        get(ConversationsListCommand::class),
    ],
];