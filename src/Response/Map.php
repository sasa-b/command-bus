<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 00:47
 */

declare(strict_types=1);

namespace SasaB\MessageBus\Response;

use SasaB\MessageBus\Response;

class Map extends Response implements \Countable, \IteratorAggregate, \ArrayAccess
{
    use Concern\CanCount;
    use Concern\CanIterate;
    use Concern\CanAccessAsArray;

    public function __construct(
        /**
         * @var array<string, mixed>
         */
        public readonly array $value
    ) {}

    public function value(): array
    {
        return $this->value;
    }
}
