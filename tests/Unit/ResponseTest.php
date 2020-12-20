<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 11:18
 */

namespace SasaB\CommandBus\Tests\Unit;


use SasaB\CommandBus\CommandBus;
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

class ResponseTest extends TestCase
{
    private CommandBus $bus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bus = new CommandBus($this->container, []);
    }

    public function testItCanReturnVoidResponse(): void
    {
        $response = $this->bus->dispatch(
            new TestCommand()
        );

        self::assertInstanceOf(None::class, $response);
    }

    public function testItCanReturnIntegerResponse(): void
    {
        $response = $this->bus->dispatch(
            new TestCommand(data: 1)
        );

        self::assertInstanceOf(Integer::class, $response);
    }

    public function testItCanReturnDoubleResponse(): void
    {
        $response = $this->bus->dispatch(
            new TestCommand(data: 2.0)
        );

        self::assertInstanceOf(Double::class, $response);
    }

    public function testItCanReturnStringResponse(): void
    {
        $response = $this->bus->dispatch(
            new TestCommand(data: 'Hello World')
        );

        self::assertInstanceOf(Text::class, $response);
    }

    public function testItCanReturnBooleanResponse(): void
    {
        $response = $this->bus->dispatch(
            new TestCommand(data: true)
        );

        self::assertInstanceOf(Boolean::class, $response);
    }

    public function testItCanReturnMapResponse(): void
    {
        $response = $this->bus->dispatch(
            new TestCommand(data: ['foo' => 'bar'])
        );

        self::assertInstanceOf(Map::class, $response);
    }

    public function testItCanReturnItemResponse(): void
    {
        $item = new \stdClass();
        $item->foo = 'bar';

        $response = $this->bus->dispatch(
            new TestCommand(data: $item)
        );

        self::assertInstanceOf(Item::class, $response);
    }

    public function testItCanReturnCollectionResponse(): void
    {
        $response = $this->bus->dispatch(
            new TestCommand(data: ['foo', 'bar'])
        );

        self::assertInstanceOf(Collection::class, $response);
    }
}