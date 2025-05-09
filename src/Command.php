<?php

declare(strict_types=1);

namespace Sco\MessageBus;

use Sco\MessageBus\Concern\CanIdentify;

/**
 * @template TCommandHandler
 * @template TCommandResult
 *
 * @implements Message<TCommandHandler,TCommandResult>
 */
abstract class Command implements Message, HasIdentity
{
    use CanIdentify;
}
