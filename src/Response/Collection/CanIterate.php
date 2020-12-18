<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 00:04
 */

namespace SasaB\CommandBus\Response\Collection;


use ArrayIterator;

trait CanIterate
{
    public function getIterator(): \Traversable
    {
        return new ArrayIterator($this->items);
    }
}