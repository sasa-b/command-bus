<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 13:25
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Tests\Unit;

use SasaB\CommandBus\Bus;
use SasaB\CommandBus\Events\CommandHandledEvent;
use SasaB\CommandBus\Events\CommandReceivedEvent;
use SasaB\CommandBus\Events\Emitter;
use SasaB\CommandBus\Events\Subscriber;
use SasaB\CommandBus\Middleware\EventMiddleware;
use SasaB\CommandBus\Middleware\TransactionMiddleware;
use SasaB\CommandBus\Tests\EchoTestCommand;
use SasaB\CommandBus\Tests\TestCase;

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

        $bus = new Bus($this->container, [$eventMiddleware]);

        $bus->dispatch(new EchoTestCommand(message: 'EchoTestCommand'));
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

        $bus = new Bus($this->container, [$transactionMiddleware]);

        $bus->dispatch(new EchoTestCommand(message: 'EchoTestCommand'));
    }
}
