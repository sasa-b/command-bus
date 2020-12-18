<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 13:25
 */

namespace SasaB\CommandBus\Tests\Unit;


use SasaB\CommandBus\CommandBus;
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
    public function testItCanEmmitEvents()
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

        $bus = new CommandBus($this->container, [$eventMiddleware]);

        $bus->dispatch(new EchoTestCommand('EchoTestCommand'));

    }

    public function testItCanExecuteInTransaction()
    {
        $this->expectOutputString(
            "Begin|EchoTestCommand Successfully Dispatched|Commit"
        );

        $transactionMiddleware = new TransactionMiddleware(
            function () { echo "Begin|"; },
            function () { echo "|Commit"; },
            function () { echo "|Rollback"; }
        );

        $bus = new CommandBus($this->container, [$transactionMiddleware]);

        $bus->dispatch(new EchoTestCommand('EchoTestCommand'));
    }
}