<?php

namespace Bot\Commands\Cli;

use Bot\App;
use Bot\Base\CliCommand;

class TestCommand extends CliCommand
{
    public function run(): void
    {
        echo $this->args[0];
        echo $this->args[1];
        echo App::getVk()->sendMessage($this->args[0], $this->args[1]);
    }
}