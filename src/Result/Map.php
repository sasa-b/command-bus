<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 00:47
 */

declare(strict_types=1);

namespace Sco\MessageBus\Result;

use Sco\MessageBus\Result;

class Map extends Result implements \Countable, \IteratorAggregate, \ArrayAccess
{
    use Concern\CanCount;
    use Concern\CanIterate;
    use Concern\CanAccessAsArray;

    public function __construct(
        /**
         * @var array<string, mixed>
         */
        public readonly array $value,
    ) {}

    public function payload(): array
    {
        return $this->value;
    }
}
