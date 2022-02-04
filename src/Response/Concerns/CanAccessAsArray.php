<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 00:05
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Response\Concerns;

use SasaB\CommandBus\Exceptions\ImmutableException;

trait CanAccessAsArray
{
    /**
     * @param int|string $offset
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->content[$offset]);
    }

    /**
     * @param int|string $offset
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->content[$offset] ?? null;
    }

    /**
     * @param int|string $offset
     * @throws ImmutableException
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw ImmutableException::mutating(__CLASS__);
    }

    /**
     * @param int|string $offset
     * @throws ImmutableException
     */
    public function offsetUnset(mixed $offset): void
    {
        throw ImmutableException::mutating(__CLASS__);
    }
}
