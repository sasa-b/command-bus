<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 15. 12. 2020.
 * Time: 21:11
 */

namespace SasaB\CommandBus\Tests\Unit;


use SasaB\CommandBus\CommandBus;
use SasaB\CommandBus\Tests\EchoTestCommand;
use SasaB\CommandBus\Tests\TestCase;

class CommandBusTest extends TestCase
{
    /**
     * @var \SasaB\CommandBus\CommandBus
     */
    private $bus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bus = new CommandBus($this->container, []);
    }

    public function testItCanDispatchCommand(): void
    {
        $this->expectOutputString(EchoTestCommand::class . " Successfully Dispatched");

        $this->bus->dispatch(
            new EchoTestCommand(EchoTestCommand::class)
        );
    }

    public function testCommandUuidAndResponseUuidAreSame(): void
    {
        $response = $this->bus->dispatch(
            $command = new EchoTestCommand(message: EchoTestCommand::class)
        );

        self::assertSame($command->uuid(), $response->uuid());
    }
}