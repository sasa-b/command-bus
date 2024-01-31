<?php

declare(strict_types=1);

namespace Sco\MessageBus;

interface Message extends HasIdentity, Payload
{
    public function payload(): mixed;
}
