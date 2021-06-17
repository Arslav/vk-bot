<?php

namespace Bot\Base;

use Bot\App;

abstract class CliCommand extends BaseCommand
{
    /**
     * AbstractCliCommand constructor.
     * @param $aliases
     */
    public function __construct($aliases)
    {
        $args = App::getArgs();
        array_shift($args);
        array_shift($args);
        parent::__construct($aliases, $args);
    }
}