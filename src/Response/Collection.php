<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 25/11/2020
 * Time: 16:36
 */

namespace SasaB\CommandBus\Response;


class Collection extends Response implements \Countable, \IteratorAggregate, \ArrayAccess
{
    use Collection\CanCount;
    use Collection\CanIterate;
    use Collection\CanAccessAsArray;

    private $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function getContent(): array
    {
        return $this->items;
    }
}