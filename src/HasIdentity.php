<?php

declare(strict_types=1);

namespace Sco\MessageBus;

interface HasIdentity
{
    public function id(): string;

    public function setId(string $id): static;
}
