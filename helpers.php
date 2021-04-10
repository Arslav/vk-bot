<?php

/**
 * @param array $collection
 * @return mixed
 */
function randomSelect(array $collection)
{
    $key = array_rand($collection);
    return $collection[$key];
}
