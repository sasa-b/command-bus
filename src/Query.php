<?php

declare(strict_types=1);

namespace Sco\MessageBus;

use Sco\MessageBus\Concern\CanIdentify;

/**
 * @template TQueryResult
 * @template TQueryHandler
 * @implements Message<TQueryResult, TQueryHandler>
 */
abstract class Query implements Message, HasIdentity
{
    use CanIdentify;
}
