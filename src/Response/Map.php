<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 00:47
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Response;

use SasaB\CommandBus\Response;

class Map extends Response implements \Countable, \IteratorAggregate, \ArrayAccess
{
    use Concerns\CanCount;
    use Concerns\CanIterate;
    use Concerns\CanAccessAsArray;
    use Concerns\CanIdentify;

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
