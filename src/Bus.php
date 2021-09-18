<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 25/11/2020
 * Time: 16:34
 */

namespace SasaB\CommandBus;


use Psr\Container\ContainerInterface;

use SasaB\CommandBus\Exceptions\MiddlewareException;
use SasaB\CommandBus\Response\Map;
use SasaB\CommandBus\Response\Item;
use SasaB\CommandBus\Response\Text;
use SasaB\CommandBus\Response\None;
use SasaB\CommandBus\Response\Double;
use SasaB\CommandBus\Response\Integer;
use SasaB\CommandBus\Response\Boolean;
use SasaB\CommandBus\Response\Collection;


class Bus implements Dispatcher
{
    private \Closure $middlewares;

    /**
     * @param ContainerInterface $diContainer
     * @param array $middleware
     * @param Mapper|null $mapper
     * @throws MiddlewareException
     */
    public function __construct(
        private ContainerInterface $diContainer,
        private array $middleware = [],
        private ?Mapper $mapper = null
    )
    {
        $this->middlewares = $this->createMiddlewareChain($middleware);
        $this->mapper = $mapper ?? new MapByName();
    }

    private function getHandlerFor(Command $command): Handler
    {
        return $this->diContainer->get(
            $this->mapper->getHandlerName($command)
        );
    }

    public function dispatch(Command $command): Response
    {
        $chain = $this->middlewares;

        $response = $this->parseResponse(
            $chain($command)
        );

        return $response->setUuid($command->uuid());
    }

    private function parseResponse(mixed $response): Response
    {
        switch ($response) {
            case null:
                return new None();
            case is_int($response):
                return new Integer(value: $response);
            case is_float($response):
                return new Double(value: $response);
            case is_bool($response):
                return new Boolean(value: $response);
            case is_string($response):
                return new Text(value: $response);
            case is_array($response):
                return $response && is_string(array_keys($response)[0])
                    ? new Map(items: $response)
                    : new Collection(items: $response);
            case $response instanceof Response:
                // do nothing, it's already a custom response object
                return $response;
            default:
                return new Item(value: $response);
        }
    }

    /**
     * @throws MiddlewareException
     */
    private function createMiddlewareChain(array $chain): \Closure
    {
        $lastMiddleware = fn (Command $command) => $this->getHandlerFor($command)->handle($command);

        while ($middleware = array_pop($chain)) {
            if (!$middleware instanceof Middleware) {
                throw MiddlewareException::invalid($middleware);
            }

            $lastMiddleware = fn (Command $command) => $middleware->handle($command, $lastMiddleware);
        }

        return $lastMiddleware;
    }
}
