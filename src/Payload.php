<?php

declare(strict_types=1);

namespace SasaB\CommandBus;

interface Payload
{
    public function payload(): mixed;
}
