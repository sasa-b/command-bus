<?php

declare(strict_types=1);

namespace SasaB\CommandBus;

interface Command extends HasIdentity
{
    public function payload(): mixed;
}
