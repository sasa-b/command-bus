<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 15. 12. 2020.
 * Time: 21:11
 */

declare(strict_types=1);

namespace SasaB\MessageBus\Tests\Unit;

use SasaB\MessageBus\Bus;
use SasaB\MessageBus\Result;
use SasaB\MessageBus\Result\Boolean;
use SasaB\MessageBus\Result\Collection;
use SasaB\MessageBus\Result\Delegated;
use SasaB\MessageBus\Result\Integer;
use SasaB\MessageBus\Result\Map;
use SasaB\MessageBus\Result\None;
use SasaB\MessageBus\Result\Numeric;
use SasaB\MessageBus\Result\Text;
use SasaB\MessageBus\Tests\Stub\AttributeTestCommand;
use SasaB\MessageBus\Tests\Stub\EchoTestCommand;
use SasaB\MessageBus\Tests\Stub\MixedContentTestCommand;
use SasaB\MessageBus\Tests\Stub\TestItemObject;
use SasaB\MessageBus\Tests\TestCase;

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
        $this->expectOutputString(EchoTestCommand::class . " Successfully Dispatched");

        $this->fixture->dispatch(
            new EchoTestCommand(EchoTestCommand::class)
        );
    }

    public function test_it_can_dispatch_command_with_attribute(): void
    {
        $result =  (new Bus($this->container, []))->dispatch(new AttributeTestCommand());

        $this->assertInstanceOf(Result::class, $result);
    }

    public function test_command_uuid_and_result_uuid_are_same(): void
    {
        $result = $this->fixture->dispatch(
            $command = new EchoTestCommand(message: EchoTestCommand::class)
        );

        $this->assertSame($command->id(), $result->id());
    }

    public function test_it_can_return_void_result(): void
    {
        $result = $this->fixture->dispatch(
            new MixedContentTestCommand(),
        );

        $this->assertInstanceOf(None::class, $result);
    }

    public function test_it_can_return_integer_result(): void
    {
        $result = $this->fixture->dispatch(
            new MixedContentTestCommand(data: 1)
        );

        $this->assertInstanceOf(Integer::class, $result);
    }

    public function test_it_can_return_double_result(): void
    {
        $result = $this->fixture->dispatch(
            new MixedContentTestCommand(data: 2.0),
        );

        $this->assertInstanceOf(Numeric::class, $result);
    }

    public function test_it_can_return_string_result(): void
    {
        $result = $this->fixture->dispatch(
            new MixedContentTestCommand(data: 'Hello World'),
        );

        $this->assertInstanceOf(Text::class, $result);
    }

    public function test_it_can_return_boolean_result(): void
    {
        $result = $this->fixture->dispatch(
            new MixedContentTestCommand(data: true)
        );

        $this->assertInstanceOf(Boolean::class, $result);
    }

    public function test_it_can_return_map_result(): void
    {
        $result = $this->fixture->dispatch(
            new MixedContentTestCommand(data: ['foo' => 'bar'])
        );

        $this->assertInstanceOf(Map::class, $result);
    }

    public function test_it_can_return_item_result(): void
    {
        $item = new \stdClass();
        $item->foo = 'bar';

        $result = $this->fixture->dispatch(
            new MixedContentTestCommand(data: $item)
        );

        $this->assertInstanceOf(Delegated::class, $result);
    }

    public function test_it_can_return_collection_result(): void
    {
        $result = $this->fixture->dispatch(
            new MixedContentTestCommand(data: ['foo', 'bar'])
        );

        $this->assertInstanceOf(Collection::class, $result);
    }

    public function test_item_result_can_delegate(): void
    {
        $item = new TestItemObject();

        $result = $this->fixture->dispatch(
            new MixedContentTestCommand(data: $item)
        );

        $this->assertInstanceOf(Delegated::class, $result);
        $this->assertSame("Item can delegate", $result->message);
        $this->assertSame("Item can delegate", $result->getMessage());
    }
}
