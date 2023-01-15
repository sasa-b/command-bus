<?php

declare(strict_types=1);

namespace SasaB\MessageBus;

interface Payload
{
    public function payload(): mixed;
}
