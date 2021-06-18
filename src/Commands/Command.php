<?php

namespace Bot\Commands;

abstract class Command
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
     * @return bool
     */
    public function beforeAction(): bool
    {
        return true;
    }

    /**
     * AbstractBaseCommand constructor.
     * @param array $aliases
     */
    public function __construct(array $aliases)
    {
        $this->aliases = $aliases;
    }

    /**
     * @return mixed
     */
    public abstract function run();
}