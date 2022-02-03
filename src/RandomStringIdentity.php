<?php

declare(strict_types=1);

namespace SasaB\CommandBus;

final class RandomStringIdentity implements Identity
{
    public function generate(): string
    {
        return bin2hex(random_bytes(12));
    }
}
