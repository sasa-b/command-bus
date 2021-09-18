<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 9. 2021.
 * Time: 23:25
 */

namespace SasaB\CommandBus\Response;

trait CanDelegate
{
    public function __get(string $name)
    {
        return $this->value->{$name} ?? null;
    }

    public function __isset(string $name): bool
    {
        return isset($this->value->{$name});
    }

    public function __call(string $name, array $arguments)
    {
        return $this->value->{$name}(...$arguments);
    }
}
