<?php

declare(strict_types=1);

namespace SasaB\MessageBus;

interface HasIdentity
{
    public function id(): string;

    public function setId(string $id): static;
}
