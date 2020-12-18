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
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getContent()
    {
        return $this->value;
    }
}