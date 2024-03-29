<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 9. 2021.
 * Time: 23:25
 */

declare(strict_types=1);

namespace Sco\MessageBus\Result\Concern;

use Sco\MessageBus\Exception\ImmutabilityException;

trait CanDelegate
{
    public function __get(string $name): mixed
    {
        return $this->value->{$name} ?? null;
    }

    public function __isset(string $name): bool
    {
        return isset($this->value->{$name});
    }

    /**
     * @throws ImmutabilityException
     */
    public function __set(string $property, mixed $value): void
    {
        throw ImmutabilityException::mutating(static::class);
    }

    public function __call(string $name, array $arguments): mixed
    {
        return $this->value->{$name}(...$arguments);
    }
}
