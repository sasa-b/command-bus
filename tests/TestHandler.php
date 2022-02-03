<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 13:12
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Tests;

use SasaB\CommandBus\Command;
use SasaB\CommandBus\Handler;

/**
 * @implements Handler<TestCommand>
 */
final class TestHandler implements Handler
{
    /**
     * @template T
     * @param Command<T> $command
     * @return mixed
     */
    public function handle(Command $command): mixed
    {
        return $command->payload();
    }
}
