<?php

declare(strict_types=1);

namespace Sco\MessageBus\Concern;

trait CanIdentify
{
    protected string $id;

    public function id(): string
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;
        return $this;
    }
}
