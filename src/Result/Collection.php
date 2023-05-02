<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 25/11/2020
 * Time: 16:36
 */

declare(strict_types=1);

namespace SasaB\MessageBus\Result;

use SasaB\MessageBus\Result;

class Collection extends Result implements \Countable, \IteratorAggregate, \ArrayAccess
{
    use Concern\CanCount;
    use Concern\CanIterate;
    use Concern\CanAccessAsArray;

    public function __construct(
        /**
         * @var array<int,mixed>
         */
        public readonly array $value,
    ) {}

    /**
     * @return array<int,mixed>
     */
    public function payload(): array
    {
        return $this->value;
    }
}
