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
    /**
     * @var \SasaB\CommandBus\CommandBus
     */
    private $bus;

    protected function setUp()
    {
        parent::setUp();

        $this->bus = new CommandBus($this->container, []);
    }

    public function testItCanReturnVoidResponse()
    {
        $response = $this->bus->dispatch(
            new TestCommand()
        );

        self::assertInstanceOf(None::class, $response);
    }

    public function testItCanReturnIntegerResponse()
    {
        $response = $this->bus->dispatch(
            new TestCommand( 1)
        );

        self::assertInstanceOf(Integer::class, $response);
    }

    public function testItCanReturnDoubleResponse()
    {
        $response = $this->bus->dispatch(
            new TestCommand(2.0)
        );

        self::assertInstanceOf(Double::class, $response);
    }

    public function testItCanReturnStringResponse()
    {
        $response = $this->bus->dispatch(
            new TestCommand('Hello World')
        );

        self::assertInstanceOf(Text::class, $response);
    }

    public function testItCanReturnBooleanResponse()
    {
        $response = $this->bus->dispatch(
            new TestCommand(true)
        );

        self::assertInstanceOf(Boolean::class, $response);
    }

    public function testItCanReturnMapResponse()
    {
        $response = $this->bus->dispatch(
            new TestCommand(['foo' => 'bar'])
        );

        self::assertInstanceOf(Map::class, $response);
    }

    public function testItCanReturnItemResponse()
    {
        $item = new \stdClass();
        $item->foo = 'bar';

        $response = $this->bus->dispatch(
            new TestCommand($item)
        );

        self::assertInstanceOf(Item::class, $response);
    }

    public function testItCanReturnCollectionResponse()
    {
        $response = $this->bus->dispatch(
            new TestCommand(['foo', 'bar'])
        );

        self::assertInstanceOf(Collection::class, $response);
    }
}