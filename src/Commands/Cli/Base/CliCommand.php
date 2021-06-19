<?php

namespace Bot\Commands\Cli\Base;

use Bot\App;
use Bot\Commands\Command;

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