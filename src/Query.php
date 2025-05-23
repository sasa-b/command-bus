<?php

declare(strict_types=1);

namespace Sco\MessageBus;

use Sco\MessageBus\Concern\CanIdentify;

/**
 * @template TQueryHandler
 * @template TQueryResult
 *
 * @implements Message<TQueryHandler,TQueryResult>
 */
abstract class Query implements Message, HasIdentity
{
    use CanIdentify;
}
