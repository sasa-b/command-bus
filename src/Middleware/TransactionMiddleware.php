<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 16. 12. 2020.
 * Time: 23:36
 */

namespace SasaB\MessageBus\Middleware;

use SasaB\MessageBus\Exception\MiddlewareException;
use SasaB\MessageBus\Message;
use SasaB\MessageBus\Middleware;

final class TransactionMiddleware implements Middleware
{
    public function __construct(
        private readonly \Closure $begin,
        private readonly \Closure $commit,
        private readonly \Closure $rollback,
    ) {}

    /**
     * @throws MiddlewareException
     */
    public function __invoke(Message $message, \Closure $next): mixed
    {
        $this->begin->call($this);
        try {
            $result = $next($message);
        } catch (\Exception $e) {
            $this->rollback->call($this);
            throw MiddlewareException::handler(handler: __CLASS__, error: $e);
        }
        $this->commit->call($this);
        return $result;
    }
}
