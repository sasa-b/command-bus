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
use SasaB\MessageBus\Response\TypeMapper;

final class Bus implements Dispatcher
{
    private Closure $chain;

    private TypeMapper $typeMapper;

    /**
     * @param array<Middleware> $middlewares
     * @throws MiddlewareException
     */
    public function __construct(
        private readonly ContainerInterface $container,
        array $middlewares = [],
        private readonly Mapper $mapper = new MapByName(),
        private readonly Identity $identity = new RandomString()
    ) {
        $this->chain = $this->createMiddlewareChain($middlewares);
        $this->typeMapper = new TypeMapper();
    }

    private function getHandlerFor(Message $command): Handler
    {
        return $this->container->get(
            $this->mapper->getHandler($command)
        );
    }

    public function dispatch(Message $command): Response
    {
        $command->setUuid(
            $this->identity->generate()
        );

        return $this->typeMapper->map(
            ($this->chain)($command)
        )->setUuid($command->uuid());
    }

    /**
     * @param array<Middleware> $chain
     * @throws MiddlewareException
     */
    private function createMiddlewareChain(array $chain): Closure
    {
        $lastMiddleware = fn (Message $command) => $this->getHandlerFor($command)($command);

        while ($middleware = array_pop($chain)) {
            if (!$middleware instanceof Middleware) {
                throw MiddlewareException::invalid($middleware);
            }

            $lastMiddleware = fn (Message $command) => ($middleware)($command, $lastMiddleware);
        }

        return $lastMiddleware;
    }
}
