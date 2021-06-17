<?php

namespace Bot\Base;

abstract class VkCommand extends BaseCommand
{
    /**
     * @var object
     */
    public $data;

    /**
     * @param $data
     * @return bool
     */
    public function beforeAction($data): bool
    {
        $this->data = $data;
        return true;
    }

    /**
     * AbstractVkCommand constructor.
     * @param $aliases
     * @param $args
     */
    public function __construct($aliases, $args)
    {
        parent::__construct($aliases, $args);
    }
}