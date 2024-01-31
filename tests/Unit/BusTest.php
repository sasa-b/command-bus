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
use Sco\MessageBus\Result;
use Sco\MessageBus\Result\Boolean;
use Sco\MessageBus\Result\Collection;
use Sco\MessageBus\Result\Delegated;
use Sco\MessageBus\Result\Integer;
use Sco\MessageBus\Result\Map;
use Sco\MessageBus\Result\None;
use Sco\MessageBus\Result\Numeric;
use Sco\MessageBus\Result\Text;
use Sco\MessageBus\Tests\Stub\AttributeTestCommand;
use Sco\MessageBus\Tests\Stub\EchoTestCommand;
use Sco\MessageBus\Tests\Stub\MixedContentTestCommand;
use Sco\MessageBus\Tests\Stub\TestItemObject;
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
