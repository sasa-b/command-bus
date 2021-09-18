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
    use CanDelegate;

    public function __construct(
        private object $value
    ) {}

    public function getContent(): object
    {
        return $this->value;
    }
}
