<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 19:03
 */

namespace SasaB\CommandBus\Response;


final class Text extends Response
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getContent(): string
    {
        return $this->value;
    }
}