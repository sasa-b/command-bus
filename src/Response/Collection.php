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

    public function __construct(
        private array $items = []
    ) {}

    public function getContent(): array
    {
        return $this->items;
    }
}