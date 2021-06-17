<?php

namespace Bot\Base;

abstract class BaseCommand
{
    /**
     * @var array
     */
    public $aliases = [];

    /**
     * @var array
     */
    public $args = [];

    /**
     * @param $data
     * @return bool
     */
    public function beforeAction($data): bool
    {
        return true;
    }

    /**
     * AbstractBaseCommand constructor.
     * @param $aliases
     * @param $args
     */
    public function __construct($aliases, $args)
    {
        $this->aliases = $aliases;
        $this->args = $args;
    }

    public abstract function run() : void;
}