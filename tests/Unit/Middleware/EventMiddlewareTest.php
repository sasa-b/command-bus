<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 13:25
 */

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Unit\Middleware;

use RuntimeException;
use Sco\MessageBus\Bus;
use Sco\MessageBus\Event\Emitter;
use Sco\MessageBus\Event\MessageFailedEvent;
use Sco\MessageBus\Event\MessageHandledEvent;
use Sco\MessageBus\Event\MessageReceivedEvent;
use Sco\MessageBus\Event\Subscriber;
use Sco\MessageBus\Middleware\EventMiddleware;
use Sco\MessageBus\Result;
use Sco\MessageBus\Result\ResultMapper;
use Sco\MessageBus\Tests\Stub\EchoTestCommand;
use Sco\MessageBus\Tests\Stub\FailingTestCommand;
use Sco\MessageBus\Tests\TestCase;

class EventMiddlewareTest extends TestCase
{
    public function test_it_can_emmit_success_events(): void
    {
        $this->expectOutputString(
            "Sco\MessageBus\Event\MessageReceivedEvent|EchoTestCommand Successfully Dispatched|Sco\MessageBus\Event\MessageHandledEvent"
        );

        $subscriber = new Subscriber();

        $subscriber->addListener(MessageReceivedEvent::class, function (MessageReceivedEvent $event) {
            echo $event->getName().'|';
            $this->assertInstanceOf(EchoTestCommand::class, $event->getMessage());
        });

        $subscriber->addListener(MessageHandledEvent::class, function (MessageHandledEvent $event) {
            echo '|'.$event->getName();
            $this->assertInstanceOf(EchoTestCommand::class, $event->getMessage());
            $this->assertInstanceOf(Result::class, $event->getResult());
        });

        $emitter = new Emitter($subscriber);

        $eventMiddleware = new EventMiddleware($emitter, new ResultMapper());

        $fixture = new Bus($this->container, [$eventMiddleware]);

        $fixture->dispatch(new EchoTestCommand(message: 'EchoTestCommand'));
    }

    public function test_it_can_emmit_failure_event(): void
    {
        $this->expectOutputString(
            "Sco\MessageBus\Event\MessageReceivedEvent|Sco\MessageBus\Event\MessageFailedEvent"
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

        $eventMiddleware = new EventMiddleware($emitter, new ResultMapper());

        $fixture = new Bus($this->container, [$eventMiddleware]);

        try {
            $fixture->dispatch(new FailingTestCommand('Whoops'));
        } catch (\Throwable) {
        }
    }
}
