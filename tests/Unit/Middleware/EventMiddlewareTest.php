<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 13:25
 */

declare(strict_types=1);

namespace SasaB\MessageBus\Tests\Unit\Middleware;

use RuntimeException;
use SasaB\MessageBus\Bus;
use SasaB\MessageBus\Event\Emitter;
use SasaB\MessageBus\Event\MessageFailedEvent;
use SasaB\MessageBus\Event\MessageHandledEvent;
use SasaB\MessageBus\Event\MessageReceivedEvent;
use SasaB\MessageBus\Event\Subscriber;
use SasaB\MessageBus\Middleware\EventMiddleware;
use SasaB\MessageBus\Response;
use SasaB\MessageBus\Response\TypeMapper;
use SasaB\MessageBus\Tests\Stub\EchoTestCommand;
use SasaB\MessageBus\Tests\Stub\FailingTestCommand;
use SasaB\MessageBus\Tests\TestCase;

class EventMiddlewareTest extends TestCase
{
    public function test_it_can_emmit_success_events(): void
    {
        $this->expectOutputString(
            "SasaB\MessageBus\Event\MessageReceivedEvent|EchoTestCommand Successfully Dispatched|SasaB\MessageBus\Event\MessageHandledEvent"
        );

        $subscriber = new Subscriber();

        $subscriber->addListener(MessageReceivedEvent::class, function (MessageReceivedEvent $event) {
            echo $event->getName().'|';
            $this->assertInstanceOf(EchoTestCommand::class, $event->getMessage());
        });

        $subscriber->addListener(MessageHandledEvent::class, function (MessageHandledEvent $event) {
            echo '|'.$event->getName();
            $this->assertInstanceOf(EchoTestCommand::class, $event->getMessage());
            $this->assertInstanceOf(Response::class, $event->getResponse());
        });

        $emitter = new Emitter($subscriber);

        $eventMiddleware = new EventMiddleware($emitter, new TypeMapper());

        $fixture = new Bus($this->container, [$eventMiddleware]);

        $fixture->dispatch(new EchoTestCommand(message: 'EchoTestCommand'));
    }

    public function test_it_can_emmit_failure_event(): void
    {
        $this->expectOutputString(
            "SasaB\MessageBus\Event\MessageReceivedEvent|SasaB\MessageBus\Event\MessageFailedEvent"
        );

        $subscriber = new Subscriber();

        $subscriber->addListener(MessageReceivedEvent::class, function (MessageReceivedEvent $event) {
            echo $event->getName().'|';
            $this->assertInstanceOf(FailingTestCommand::class, $event->getMessage());
        });

        $subscriber->addListener(MessageFailedEvent::class, function (MessageFailedEvent $event) {
            echo $event->getName();
            $this->assertInstanceOf(FailingTestCommand::class, $event->getMessage());
            $this->assertInstanceOf(RuntimeException::class, $event->getError());
        });

        $emitter = new Emitter($subscriber);

        $eventMiddleware = new EventMiddleware($emitter, new TypeMapper());

        $fixture = new Bus($this->container, [$eventMiddleware]);

        try {
            $fixture->dispatch(new FailingTestCommand('Whoops'));
        } catch (\Throwable) {
        }
    }
}
