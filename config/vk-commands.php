<?php

use Bot\Commands\Vk\AutistCommand;
use Bot\Commands\Vk\BlyaCommand;
use Bot\Commands\Vk\GiveMePillsCommand;
use Bot\Commands\Vk\KickMeCommand;
use Bot\Commands\Vk\PressFCommand;
use Bot\Commands\Vk\WhoAmICommand;
use Bot\Commands\Vk\WhoWeCommand;
use Bot\Commands\Vk\WowSpecTopCommand;
use function DI\create;
use function DI\get;

return [
    AutistCommand::class => create()
        ->constructor([
            '^ыы+$',
            '^кря+$',
            '^ря+$',
            '^[аы]{2,}$'
        ])
        ->property('limit', 20),
    BlyaCommand::class => create()->constructor(['^ля+$']),
    GiveMePillsCommand::class => create()->constructor(['сла+ва+(\,)? дай табле(тки+|то+к)\s?[(\!)(\?)]*$']),
    KickMeCommand::class => create()->constructor(['^сла+ва+(\,)? не ки+ка+й\s?[(\!)(\?)]*$']),
    PressFCommand::class => create()->constructor(['(.*\s|^)f([\.\!\?\,]|\s.*|$)']),
    WhoAmICommand::class => create()->constructor(['^сла+ва+(\,)? [кчх]то+ я\s?(\?)*$']),
    WhoWeCommand::class => create()->constructor(['^сла+ва+(\,)? [хк]то+ мы+\s?(\?)*$']),
    WowSpecTopCommand::class => create()->constructor(['^сла+ва+(\,)? [хк]то+ (сегодня\s)?топ\s?[(\!)(\?)]*$']),

    'vk-commands' => [
        get(AutistCommand::class),
        get(BlyaCommand::class),
        get(GiveMePillsCommand::class),
        get(KickMeCommand::class),
        get(PressFCommand::class),
        get(WhoAmICommand::class),
        get(WhoWeCommand::class),
        get(WowSpecTopCommand::class),
    ]
];