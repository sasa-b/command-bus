<?php

declare(strict_types=1);

namespace Sco\MessageBus;

interface Identity
{
    public function generate(): string;
}
