<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 25/11/2020
 * Time: 16:34
 */

declare(strict_types=1);

namespace SasaB\MessageBus;

use Closure;
use Psr\Container\ContainerInterface;
use SasaB\MessageBus\Exception\MiddlewareException;
use SasaB\MessageBus\Identity\RandomString;
use SasaB\MessageBus\Mapper\Mapper;
use SasaB\MessageBus\Mapper\Strategy\MapByName;
use SasaB\MessageBus\Result\ResultMapper;

final class Bus implements Dispatcher
{
    private Closure $chain;

    /**
     * @param array<Middleware> $middlewares
     * @throws MiddlewareException
     */
    public function __construct(
        private readonly ContainerInterface $container,
        array                               $middlewares = [],
        private readonly Mapper             $mapper = new MapByName(),
        private readonly Identity           $identity = new RandomString(),
        private readonly ?ResultMapper      $resultMapper = new ResultMapper(),
    ) {
        $this->chain = $this->createMiddlewareChain($middlewares);
    }

    private function getHandlerFor(Message $message): Handler
    {
        return $this->container->get(
            $this->mapper->getHandler($message),
        );
    }

    public function dispatch(Message $message): Result
    {
        $message->setId(
            $this->identity->generate(),
        );

        $result = ($this->chain)($message);

        return $this->resultMapper !== null ? $this->resultMapper->map($result)->setId($message->id()) : $result;
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
