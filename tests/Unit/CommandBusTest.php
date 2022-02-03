<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 15. 12. 2020.
 * Time: 21:11
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Tests\Unit;

use SasaB\CommandBus\Bus;
use SasaB\CommandBus\Tests\EchoTestCommand;
use SasaB\CommandBus\Tests\TestCase;

class CommandBusTest extends TestCase
{
    private Bus $bus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bus = new Bus($this->container, []);
    }

    public function test_it_can_dispatch_command(): void
    {
        $this->expectOutputString(EchoTestCommand::class . " Successfully Dispatched");

        $this->bus->dispatch(
            new EchoTestCommand(EchoTestCommand::class)
        );
    }

    public function test_command_uuid_and_response_uuid_are_same(): void
    {
        $response = $this->bus->dispatch(
            $command = new EchoTestCommand(message: EchoTestCommand::class)
        );

        self::assertSame($command->uuid(), $response->uuid());
    }
}
