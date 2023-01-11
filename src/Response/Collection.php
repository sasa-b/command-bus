<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 25/11/2020
 * Time: 16:36
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Response;

use SasaB\CommandBus\Response;

class Collection extends Response implements \Countable, \IteratorAggregate, \ArrayAccess
{
    use Concerns\CanCount;
    use Concerns\CanIterate;
    use Concerns\CanAccessAsArray;
    use Concerns\CanIdentify;

    public function __construct(
        /**
         * @var array<int,mixed>
         */
        public readonly array $content
    ) {}

    /**
     * @return array<int,mixed>
     */
    public function content(): array
    {
        return $this->content;
    }
}
