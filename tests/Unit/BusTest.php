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
use SasaB\CommandBus\Response\Boolean;
use SasaB\CommandBus\Response\Collection;
use SasaB\CommandBus\Response\Delegated;
use SasaB\CommandBus\Response\Integer;
use SasaB\CommandBus\Response\Map;
use SasaB\CommandBus\Response\None;
use SasaB\CommandBus\Response\Numeric;
use SasaB\CommandBus\Response\Text;
use SasaB\CommandBus\Tests\Stub\EchoTestMessage;
use SasaB\CommandBus\Tests\Stub\MixedContentTestMessage;
use SasaB\CommandBus\Tests\Stub\TestItemObject;
use SasaB\CommandBus\Tests\TestCase;

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
        $this->expectOutputString(EchoTestMessage::class . " Successfully Dispatched");

        $this->fixture->dispatch(
            new EchoTestMessage(EchoTestMessage::class)
        );
    }

    public function test_command_uuid_and_response_uuid_are_same(): void
    {
        $response = $this->fixture->dispatch(
            $command = new EchoTestMessage(message: EchoTestMessage::class)
        );

        self::assertSame($command->uuid(), $response->uuid());
    }

    public function test_it_can_return_void_response(): void
    {
        $response = $this->fixture->dispatch(
            new MixedContentTestMessage()
        );

        self::assertInstanceOf(None::class, $response);
    }

    public function test_it_can_return_integer_response(): void
    {
        $response = $this->fixture->dispatch(
            new MixedContentTestMessage(data: 1)
        );

        self::assertInstanceOf(Integer::class, $response);
    }

    public function test_it_can_return_double_response(): void
    {
        $response = $this->fixture->dispatch(
            new MixedContentTestMessage(data: 2.0)
        );

        self::assertInstanceOf(Numeric::class, $response);
    }

    public function test_it_can_return_string_response(): void
    {
        $response = $this->fixture->dispatch(
            new MixedContentTestMessage(data: 'Hello World')
        );

        self::assertInstanceOf(Text::class, $response);
    }

    public function test_it_can_return_boolean_response(): void
    {
        $response = $this->fixture->dispatch(
            new MixedContentTestMessage(data: true)
        );

        self::assertInstanceOf(Boolean::class, $response);
    }

    public function test_it_can_return_map_response(): void
    {
        $response = $this->fixture->dispatch(
            new MixedContentTestMessage(data: ['foo' => 'bar'])
        );

        self::assertInstanceOf(Map::class, $response);
    }

    public function test_it_can_return_item_response(): void
    {
        $item = new \stdClass();
        $item->foo = 'bar';

        $response = $this->fixture->dispatch(
            new MixedContentTestMessage(data: $item)
        );

        self::assertInstanceOf(Delegated::class, $response);
    }

    public function test_it_can_return_collection_response(): void
    {
        $response = $this->fixture->dispatch(
            new MixedContentTestMessage(data: ['foo', 'bar'])
        );

        self::assertInstanceOf(Collection::class, $response);
    }

    public function test_item_response_can_delegate(): void
    {
        $item = new TestItemObject();

        $response = $this->fixture->dispatch(
            new MixedContentTestMessage(data: $item)
        );

        self::assertInstanceOf(Delegated::class, $response);
        self::assertSame("Item can delegate", $response->message);
        self::assertSame("Item can delegate", $response->getMessage());
    }
}
