<?php

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Unit\Middleware;

use Sco\MessageBus\Bus;
use Sco\MessageBus\Middleware\TransactionMiddleware;
use Sco\MessageBus\Tests\Stub\EchoTestCommand;
use Sco\MessageBus\Tests\Stub\FailingTestCommand;
use Sco\MessageBus\Tests\TestCase;

class TransactionMiddlewareTest extends TestCase
{
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
            },
        );

        $fixture = new Bus($this->container, [$transactionMiddleware]);

        $fixture->dispatch(new EchoTestCommand(message: 'EchoTestCommand'));
    }

    public function test_it_rollbacks_transaction_on_error(): void
    {
        $this->expectOutputString(
            "Begin|Rollback Command Fails"
        );

        $transactionMiddleware = new TransactionMiddleware(
            function () {
                echo "Begin|";
            },
            function () {
                echo "|Commit";
            },
            function (\Throwable $throwable) {
                echo "Rollback ".$throwable->getMessage();
            },
        );

        $fixture = new Bus($this->container, [$transactionMiddleware]);

        try {
            $fixture->dispatch(new FailingTestCommand('Whoops'));
        } catch (\Throwable) {
        }
    }
}
