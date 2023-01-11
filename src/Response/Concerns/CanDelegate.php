<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 9. 2021.
 * Time: 23:25
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Response\Concerns;

use SasaB\CommandBus\Exceptions\ImmutabilityException;

trait CanDelegate
{
    public function __get(string $name): mixed
    {
        return $this->content->{$name} ?? null;
    }

    public function __isset(string $name): bool
    {
        return isset($this->content->{$name});
    }

    /**
     * @throws ImmutabilityException
     */
    public function __set(string $property, mixed $value): void
    {
        throw ImmutabilityException::mutating(__CLASS__);
    }

    public function __call(string $name, array $arguments): mixed
    {
        return $this->content->{$name}(...$arguments);
    }
}
