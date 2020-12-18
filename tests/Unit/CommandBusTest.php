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

    protected function setUp()
    {
        parent::setUp();

        $this->bus = new CommandBus($this->container, []);
    }

    public function testItCanDispatchCommand()
    {
        $this->expectOutputString(EchoTestCommand::class . " Successfully Dispatched");

        $this->bus->dispatch(
            new EchoTestCommand(EchoTestCommand::class)
        );
    }

    public function testCommandUuidAndResponseUuidAreSame()
    {
        $response = $this->bus->dispatch(
            $command = new EchoTestCommand(EchoTestCommand::class)
        );

        self::assertSame($command->uuid(), $response->uuid());
    }
}