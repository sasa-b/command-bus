<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 15. 12. 2020.
 * Time: 21:11
 */

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Unit;

use Sco\MessageBus\Bus;
use Sco\MessageBus\Tests\Stub\EchoCommand;
use Sco\MessageBus\Tests\Stub\FooCommand;
use Sco\MessageBus\Tests\Stub\MappedByAttributeCommand;
use Sco\MessageBus\Tests\TestCase;

class BusTest extends TestCase
{
    private Bus $fixture;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fixture = new Bus($this->container, []);
    }

    public function test_it_can_dispatch_command(): void
    {
        $this->expectOutputString(EchoCommand::class . " Successfully Dispatched");

        $this->fixture->dispatch(
            new EchoCommand(EchoCommand::class)
        );
    }

    public function test_it_can_dispatch_command_with_attribute(): void
    {
        $result = (new Bus($this->container, []))->dispatch(new MappedByAttributeCommand());

        $this->assertSame('Command is mapped by attribute', $result);
    }

    public function test_command_uuid_and_result_uuid_are_same(): void
    {
        $result = $this->fixture->dispatch(
            $command = new FooCommand()
        );

        $this->assertSame($command->id(), $result->id());
    }
}
