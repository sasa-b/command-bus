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
    private $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public function getContent(): float
    {
        return $this->value;
    }
}