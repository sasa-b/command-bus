<?php

declare(strict_types=1);

namespace SasaB\MessageBus;

interface Identity
{
    public function generate(): string;
}
