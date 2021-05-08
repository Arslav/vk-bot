<?php

namespace Bot\Base;

abstract class AbstractBaseCommand
{
    /**
     * @var array
     */
    public $aliases = [];

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
     */
    public function __construct($aliases)
    {
        $this->aliases = $aliases;
    }

    /**
     * @param $data
     */
    public abstract function action($data) : void;
}