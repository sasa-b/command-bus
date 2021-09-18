<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 25/11/2020
 * Time: 16:36
 */

namespace SasaB\CommandBus\Response;


class Item extends Response
{
    public function __construct(
        private object|array $value
    ) {}

    public function getContent(): object|array
    {
        return $this->value;
    }
}
