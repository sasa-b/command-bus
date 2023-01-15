<?php

declare(strict_types=1);

namespace SasaB\CommandBus;

interface Feedback extends HasIdentity
{
    public function value(): mixed;
}
