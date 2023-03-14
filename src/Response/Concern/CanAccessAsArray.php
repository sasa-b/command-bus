<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 00:05
 */

declare(strict_types=1);

namespace SasaB\MessageBus\Response\Concern;

use SasaB\MessageBus\Exception\ImmutabilityException;

trait CanAccessAsArray
{
    /**
     * @param int|string $offset
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->value[$offset]);
    }

    /**
     * @param int|string $offset
     * @return mixed
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->value[$offset] ?? null;
    }

    /**
     * @param int|string $offset
     * @param mixed $value
     * @throws ImmutabilityException
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw ImmutabilityException::mutating(static::class);
    }

    /**
     * @param int|string $offset
     * @throws ImmutabilityException
     */
    public function offsetUnset(mixed $offset): void
    {
        throw ImmutabilityException::mutating(static::class);
    }
}
