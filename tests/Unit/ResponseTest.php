<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 11:18
 */

namespace SasaB\CommandBus\Tests\Unit;


use SasaB\CommandBus\Bus;
use SasaB\CommandBus\Response\Boolean;
use SasaB\CommandBus\Response\Collection;
use SasaB\CommandBus\Response\Double;
use SasaB\CommandBus\Response\Integer;
use SasaB\CommandBus\Response\Item;
use SasaB\CommandBus\Response\Map;
use SasaB\CommandBus\Response\Text;
use SasaB\CommandBus\Response\None;
use SasaB\CommandBus\Tests\TestCommand;
use SasaB\CommandBus\Tests\TestCase;
use SasaB\CommandBus\Tests\TestItemObject;

class ResponseTest extends TestCase
{
    private Bus $bus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bus = new Bus($this->container, []);
    }

    public function test_it_can_return_void_response(): void
    {
        $response = $this->bus->dispatch(
            new TestCommand()
        );

        self::assertInstanceOf(None::class, $response);
    }

    public function test_it_can_return_integer_response(): void
    {
        $response = $this->bus->dispatch(
            new TestCommand(data: 1)
        );

        self::assertInstanceOf(Integer::class, $response);
    }

    public function test_it_can_return_double_response(): void
    {
        $response = $this->bus->dispatch(
            new TestCommand(data: 2.0)
        );

        self::assertInstanceOf(Double::class, $response);
    }

    public function test_it_can_return_string_response(): void
    {
        $response = $this->bus->dispatch(
            new TestCommand(data: 'Hello World')
        );

        self::assertInstanceOf(Text::class, $response);
    }

    public function test_it_can_return_boolean_response(): void
    {
        $response = $this->bus->dispatch(
            new TestCommand(data: true)
        );

        self::assertInstanceOf(Boolean::class, $response);
    }

    public function test_it_can_return_map_response(): void
    {
        $response = $this->bus->dispatch(
            new TestCommand(data: ['foo' => 'bar'])
        );

        self::assertInstanceOf(Map::class, $response);
    }

    public function test_it_can_return_item_response(): void
    {
        $item = new \stdClass();
        $item->foo = 'bar';

        $response = $this->bus->dispatch(
            new TestCommand(data: $item)
        );

        self::assertInstanceOf(Item::class, $response);
    }

    public function test_it_can_return_collection_response(): void
    {
        $response = $this->bus->dispatch(
            new TestCommand(data: ['foo', 'bar'])
        );

        self::assertInstanceOf(Collection::class, $response);
    }

    public function test_item_response_can_delegate()
    {
        $item = new TestItemObject();

        $response = $this->bus->dispatch(
            new TestCommand(data: $item)
        );

        self::assertSame("Item can delegate", $response->message);
        self::assertSame("Item can delegate", $response->getMessage());
    }
}
