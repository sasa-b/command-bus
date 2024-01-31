<?php

declare(strict_types=1);

namespace Sco\MessageBus;

interface Payload
{
    public function payload(): mixed;
}
