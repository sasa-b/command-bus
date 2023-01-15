<?php

declare(strict_types=1);

namespace SasaB\MessageBus;

interface Message extends HasIdentity, Payload
{
    public function payload(): mixed;
}
