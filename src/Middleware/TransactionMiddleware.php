<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 16. 12. 2020.
 * Time: 23:36
 */

namespace SasaB\CommandBus\Middleware;

use SasaB\CommandBus\Command;
use SasaB\CommandBus\Exceptions\MiddlewareException;
use SasaB\CommandBus\Middleware;

final class TransactionMiddleware implements Middleware
{
    public function __construct(
        private readonly \Closure $begin,
        private readonly \Closure $commit,
        private readonly \Closure $rollback
    ) {}

    /**
     * @throws MiddlewareException
     */
    public function __invoke(Command $command, \Closure $next): mixed
    {
        call_user_func($this->begin);
        try {
            $result = $next($command);
        } catch (\Exception $e) {
            call_user_func($this->rollback);
            throw MiddlewareException::handler(handler: __CLASS__, error: $e);
        }
        call_user_func($this->commit);
        return $result;
    }
}
