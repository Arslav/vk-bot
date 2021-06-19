<?php

namespace Bot\Commands\Vk\Cli\Base;

use Bot\App;
use Bot\Commands\Vk\Command;

abstract class CliCommand extends Command
{
    /**
     * CliCommand constructor.
     * @param array $aliases
     */
    public function __construct(array $aliases)
    {
        $this->args = App::getArgs();
        array_shift($this->args);
        parent::__construct($aliases);
    }

}