<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 12:03
 */

namespace SasaB\CommandBus\Response;


final class Double extends Response
{
    public function __construct(
        private float $value
    ) {}

    public function getContent(): float
    {
        return $this->value;
    }
}