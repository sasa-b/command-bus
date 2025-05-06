<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 15. 12. 2020.
 * Time: 21:11
 */

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use Sco\MessageBus\Bus;
use Sco\MessageBus\Mapper\Strategy\MapByAttribute;
use Sco\MessageBus\Tests\Stub\EchoCommand;
use Sco\MessageBus\Tests\Stub\FooCommand;
use Sco\MessageBus\Tests\Stub\FooMessage;
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

    #[Test]
    public function it_can_dispatch_command(): void
    {
        $this->expectOutputString(EchoCommand::class . " Successfully Dispatched");

        $this->fixture->dispatch(
            new EchoCommand(EchoCommand::class)
        );
    }

    #[Test]
    public function it_can_dispatch_command_with_attribute(): void
    {
        $result = new Bus(container: $this->container, mapper: new MapByAttribute())->dispatch(new MappedByAttributeCommand());

        $this->assertSame('Command is mapped by attribute', $result);
    }

    #[Test]
    public function it_can_assign_unique_identity_to_results(): void
    {
        $result = new Bus(container: $this->container, mapper: new MapByAttribute())->dispatch(new FooMessage());

        $this->assertSame('FooMessage Handled', $result->value());
        $this->assertNotEmpty($result->id());
    }

    #[Test]
    public function command_identity_and_result_identity_are_the_same(): void
    {
        $result = $this->fixture->dispatch(
            $command = new FooCommand()
        );

        $this->assertSame($command->id(), $result->id());
    }
}
