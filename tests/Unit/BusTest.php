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
use SasaB\MessageBus\Response;
use SasaB\MessageBus\Response\Boolean;
use SasaB\MessageBus\Response\Collection;
use SasaB\MessageBus\Response\Delegated;
use SasaB\MessageBus\Response\Integer;
use SasaB\MessageBus\Response\Map;
use SasaB\MessageBus\Response\None;
use SasaB\MessageBus\Response\Numeric;
use SasaB\MessageBus\Response\Text;
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
        $response =  (new Bus($this->container, []))->dispatch(new AttributeTestCommand());

        $this->assertInstanceOf(Response::class, $response);
    }

    public function test_command_uuid_and_response_uuid_are_same(): void
    {
        $response = $this->fixture->dispatch(
            $command = new EchoTestCommand(message: EchoTestCommand::class)
        );

        $this->assertSame($command->id(), $response->id());
    }

    public function test_it_can_return_void_response(): void
    {
        $response = $this->fixture->dispatch(
            new MixedContentTestCommand(),
        );

        $this->assertInstanceOf(None::class, $response);
    }

    public function test_it_can_return_integer_response(): void
    {
        $response = $this->fixture->dispatch(
            new MixedContentTestCommand(data: 1)
        );

        $this->assertInstanceOf(Integer::class, $response);
    }

    public function test_it_can_return_double_response(): void
    {
        $response = $this->fixture->dispatch(
            new MixedContentTestCommand(data: 2.0),
        );

        $this->assertInstanceOf(Numeric::class, $response);
    }

    public function test_it_can_return_string_response(): void
    {
        $response = $this->fixture->dispatch(
            new MixedContentTestCommand(data: 'Hello World'),
        );

        $this->assertInstanceOf(Text::class, $response);
    }

    public function test_it_can_return_boolean_response(): void
    {
        $response = $this->fixture->dispatch(
            new MixedContentTestCommand(data: true)
        );

        $this->assertInstanceOf(Boolean::class, $response);
    }

    public function test_it_can_return_map_response(): void
    {
        $response = $this->fixture->dispatch(
            new MixedContentTestCommand(data: ['foo' => 'bar'])
        );

        $this->assertInstanceOf(Map::class, $response);
    }

    public function test_it_can_return_item_response(): void
    {
        $item = new \stdClass();
        $item->foo = 'bar';

        $response = $this->fixture->dispatch(
            new MixedContentTestCommand(data: $item)
        );

        $this->assertInstanceOf(Delegated::class, $response);
    }

    public function test_it_can_return_collection_response(): void
    {
        $response = $this->fixture->dispatch(
            new MixedContentTestCommand(data: ['foo', 'bar'])
        );

        $this->assertInstanceOf(Collection::class, $response);
    }

    public function test_item_response_can_delegate(): void
    {
        $item = new TestItemObject();

        $response = $this->fixture->dispatch(
            new MixedContentTestCommand(data: $item)
        );

        $this->assertInstanceOf(Delegated::class, $response);
        $this->assertSame("Item can delegate", $response->message);
        $this->assertSame("Item can delegate", $response->getMessage());
    }
}
