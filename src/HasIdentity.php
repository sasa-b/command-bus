<?php

declare(strict_types=1);

namespace SasaB\CommandBus;

interface HasIdentity
{
    public function uuid(): string;

    public function setUuid(string $uuid): static;
}
