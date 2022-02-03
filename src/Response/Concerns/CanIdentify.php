<?php

declare(strict_types=1);

namespace SasaB\CommandBus\Response\Concerns;

trait CanIdentify
{
    protected string $uuid;

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): static
    {
        $this->uuid = $uuid;
        return $this;
    }
}
