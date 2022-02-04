<?php

declare(strict_types=1);

namespace SasaB\CommandBus;

interface Identity extends \Stringable
{
    public function generate(): string;
}
