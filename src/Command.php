<?php

declare(strict_types=1);

namespace Sco\MessageBus;

use Sco\MessageBus\Concern\CanIdentify;

/**
 * @template TCommandResult
 * @template TCommandHandler
 * @implements Message<TCommandResult, TCommandHandler>
 */
abstract class Command implements Message, HasIdentity
{
    use CanIdentify;
}
