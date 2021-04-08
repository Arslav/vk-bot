<?php

namespace Bot\Commands;

abstract class AbstractBaseCommand
{
    /**
     * @var array
     */
    public $aliases = [];


    public function __construct($aliases)
    {
        $this->aliases = $aliases;
    }

    /**
     * @param $data
     */
    public abstract function action($data) : void;
}