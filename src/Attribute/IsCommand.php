<?php

declare(strict_types=1);

namespace SasaB\CommandBus\Attribute;

#[\Attribute]
class IsCommand
{
    /**
     * @param class-string $handler
     */
    public function __construct(public readonly string $handler) {}
}
