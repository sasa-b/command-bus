<?php

declare(strict_types=1);

namespace SasaB\CommandBus;

interface Message extends HasIdentity
{
    public function payload(): mixed;
}
