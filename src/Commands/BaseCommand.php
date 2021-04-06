<?php

namespace Bot\Commands;

abstract class BaseCommand
{
    /**
     * @var array
     */
    public $aliases = [];

    /**
     * @param $data
     */
    public abstract function action($data) : void;


}