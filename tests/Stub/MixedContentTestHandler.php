<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 13:12
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Tests\Stub;

use SasaB\CommandBus\Command;
use SasaB\CommandBus\Handler;

/**
 * @implements Handler<MixedContentTestCommand>
 */
final class MixedContentTestHandler implements Handler
{
    public function handle(Command $command): mixed
    {
        return $command->payload();
    }
}
