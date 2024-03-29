<?php

declare(strict_types=1);

namespace Sco\MessageBus\Identity;

use Sco\MessageBus\Identity;

final class RandomString implements Identity
{
    public function generate(): string
    {
        return bin2hex(random_bytes(12));
    }

    public function __toString()
    {
        return $this->generate();
    }
}
