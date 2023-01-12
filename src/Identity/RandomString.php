<?php

declare(strict_types=1);

namespace SasaB\CommandBus\Identity;

use SasaB\CommandBus\Identity;

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
