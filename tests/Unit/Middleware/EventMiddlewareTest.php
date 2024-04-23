<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 13:25
 */

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Unit\Middleware;

use PHPUnit\Framework\Attributes\Test;
use RuntimeException;
use Sco\MessageBus\Bus;
use Sco\MessageBus\Event\Emitter;
use Sco\MessageBus\Event\MessageFailedEvent;
use Sco\MessageBus\Event\MessageHandledEvent;
use Sco\MessageBus\Event\MessageReceivedEvent;
use Sco\MessageBus\Event\Subscriber;
use Sco\MessageBus\Middleware\EventMiddleware;
use Sco\MessageBus\Tests\Stub\EchoCommand;
use Sco\MessageBus\Tests\Stub\FailingCommand;
use Sco\MessageBus\Tests\TestCase;

class EventMiddlewareTest extends TestCase
{
    #[Test]
    public function it_can_emmit_success_events(): void
    {
        $this->expectOutputString(
            "Sco\MessageBus\Event\MessageReceivedEvent|EchoTestCommand Successfully Dispatched|Sco\MessageBus\Event\MessageHandledEvent"
        );

        $subscriber = new Subscriber();

        $subscriber->addListener(MessageReceivedEvent::class, function (MessageReceivedEvent $event) {
            echo $event->getName().'|';
            $this->assertInstanceOf(EchoCommand::class, $event->message);
        });

        $subscriber->addListener(MessageHandledEvent::class, function (MessageHandledEvent $event) {
            echo '|'.$event->getName();
            $this->assertInstanceOf(EchoCommand::class, $event->message);
            $this->assertSame(0, $event->result);
        });

        $emitter = new Emitter($subscriber);

        $eventMiddleware = new EventMiddleware($emitter);

        $fixture = new Bus($this->container, [$eventMiddleware]);

        $fixture->dispatch(new EchoCommand(message: 'EchoTestCommand'));
    }

    #[Test]
    public function it_can_emmit_failure_event(): void
    {
        $this->expectOutputString(
            "Sco\MessageBus\Event\MessageReceivedEvent|Sco\MessageBus\Event\MessageFailedEvent"
        );

        $subscriber = new Subscriber();

        $subscriber->addListener(MessageReceivedEvent::class, function (MessageReceivedEvent $event) {
            echo $event->getName().'|';
            $this->assertInstanceOf(FailingCommand::class, $event->message);
        });

        $subscriber->addListener(MessageFailedEvent::class, function (MessageFailedEvent $event) {
            echo $event->getName();
            $this->assertInstanceOf(FailingCommand::class, $event->message);
            $this->assertInstanceOf(RuntimeException::class, $event->error);
        });

        $emitter = new Emitter($subscriber);

        $eventMiddleware = new EventMiddleware($emitter);

        $fixture = new Bus($this->container, [$eventMiddleware]);

        try {
            $fixture->dispatch(new FailingCommand('Whoops'));
        } catch (\Throwable) {
        }
    }
}
