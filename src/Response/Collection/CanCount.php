<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 00:04
 */

namespace SasaB\CommandBus\Response\Collection;


trait CanCount
{
    public function count(): int
    {
        return count($this->items);
    }
}