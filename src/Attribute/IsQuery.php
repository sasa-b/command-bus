<?php

declare(strict_types=1);

namespace SasaB\CommandBus\Attribute;

#[\Attribute]
class IsQuery
{
    /**
     * @param class-string $handledBy
     */
    public function __construct(public readonly string $handledBy) {}
}
