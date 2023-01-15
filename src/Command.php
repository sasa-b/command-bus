<?php

declare(strict_types=1);

namespace SasaB\CommandBus;

use SasaB\CommandBus\Concern\CanIdentify;

abstract class Command implements Message
{
    use CanIdentify;
}
