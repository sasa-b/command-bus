<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 13:25
 */

declare(strict_types=1);

namespace SasaB\MessageBus\Tests\Unit;

use SasaB\MessageBus\Bus;
use SasaB\MessageBus\Event\CommandHandledEvent;
use SasaB\MessageBus\Event\CommandReceivedEvent;
use SasaB\MessageBus\Event\Emitter;
use SasaB\MessageBus\Event\Subscriber;
use SasaB\MessageBus\Middleware\EventMiddleware;
use SasaB\MessageBus\Middleware\TransactionMiddleware;
use SasaB\MessageBus\Tests\Stub\EchoTestCommand;
use SasaB\MessageBus\Tests\TestCase;

class MiddlewareTest extends TestCase
{
    public function test_it_can_emmit_events(): void
    {
        $this->expectOutputString(
            "Command Received|EchoTestCommand Successfully Dispatched|Command Handled"
        );

        $subscriber = new Subscriber();

        $subscriber->addListener(CommandReceivedEvent::class, function () {
            echo "Command Received|";
        });

        $subscriber->addListener(CommandHandledEvent::class, function () {
            echo "|Command Handled";
        });

        $emitter = new Emitter($subscriber);

        $eventMiddleware = new EventMiddleware($emitter);

        $fixture = new Bus($this->container, [$eventMiddleware]);

        $fixture->dispatch(new EchoTestCommand(message: 'EchoTestCommand'));
    }

    public function test_it_can_execute_in_transaction(): void
    {
        $this->expectOutputString(
            "Begin|EchoTestCommand Successfully Dispatched|Commit"
        );

        $transactionMiddleware = new TransactionMiddleware(
            function () {
                echo "Begin|";
            },
            function () {
                echo "|Commit";
            },
            function () {
                echo "|Rollback";
            }
        );

        $fixture = new Bus($this->container, [$transactionMiddleware]);

        $fixture->dispatch(new EchoTestCommand(message: 'EchoTestCommand'));
    }
}
