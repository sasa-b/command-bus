<?php

declare(strict_types=1);

namespace SasaB\MessageBus\Concern;

trait CanIdentify
{
    protected string $uuid;

    public function id(): string
    {
        return $this->uuid;
    }

    public function setId(string $id): static
    {
        $this->uuid = $id;
        return $this;
    }
}
