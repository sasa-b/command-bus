<?php

declare(strict_types=1);

namespace SasaB\CommandBus;

interface Identity
{
    public function generate(): string;
}
