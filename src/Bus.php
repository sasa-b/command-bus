<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 25/11/2020
 * Time: 16:34
 */

declare(strict_types=1);

namespace Sco\MessageBus;

use Closure;
use Psr\Container\ContainerInterface;
use Sco\MessageBus\Exception\MiddlewareException;
use Sco\MessageBus\Identity\RandomString;
use Sco\MessageBus\Mapper\Mapper;
use Sco\MessageBus\Mapper\Strategy\MapByName;

final readonly class Bus implements Dispatcher
{
    private Closure $chain;

    /**
     * @param array<Middleware> $middlewares
     * @throws MiddlewareException
     */
    public function __construct(
        private ContainerInterface $container,
        array $middlewares = [],
        private Mapper $mapper = new MapByName(),
        private Identity $identity = new RandomString(),
    ) {
        $this->chain = $this->createMiddlewareChain($middlewares);
    }

    private function getHandlerFor(Message $message): Handler
    {
        return $this->container->get(
            $this->mapper->getHandler($message),
        );
    }

    /**
     * @template TResult of mixed
     * @param Message<TResult,*> $message
     * @return TResult
     */
    public function dispatch(Message $message): mixed
    {
        if ($message instanceof HasIdentity) {
            $message->setId(
                $this->identity->generate(),
            );
        }

        $result = ($this->chain)($message);

        if (
            $message instanceof HasIdentity &&
            $result instanceof HasIdentity
        ) {
            $result->setId($message->id());
        }

        return $result;
    }

    /**
     * @param array<Middleware> $chain
     * @throws MiddlewareException
     */
    private function createMiddlewareChain(array $chain): Closure
    {
        $lastMiddleware = fn (Message $message) => $this->getHandlerFor($message)($message);

        while ($middleware = array_pop($chain)) {
            if (!$middleware instanceof Middleware) {
                throw MiddlewareException::invalid($middleware);
            }

            $lastMiddleware = fn (Message $message) => ($middleware)($message, $lastMiddleware);
        }

        return $lastMiddleware;
    }
}
