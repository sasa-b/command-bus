<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 9. 2021.
 * Time: 23:25
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Response\Concerns;

use SasaB\CommandBus\Exceptions\ImmutableException;

/**
 * @template T
 * @mixin T
 */
trait CanDelegate
{
    public function __get(string $name)
    {
        return $this->content->{$name} ?? null;
    }

    public function __isset(string $name): bool
    {
        return isset($this->content->{$name});
    }

    /**
     * @throws ImmutableException
     */
    public function __set(string $property, mixed $value)
    {
        throw ImmutableException::mutating(__CLASS__);
    }

    public function __call(string $name, array $arguments)
    {
        return $this->content->{$name}(...$arguments);
    }
}
