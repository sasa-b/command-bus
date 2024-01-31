<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 16. 12. 2020.
 * Time: 23:36
 */

namespace Sco\MessageBus\Middleware;

use Sco\MessageBus\Message;
use Sco\MessageBus\Middleware;

final class TransactionMiddleware implements Middleware
{
    public function __construct(
        private readonly \Closure $begin,
        private readonly \Closure $commit,
        private readonly \Closure $rollback,
    ) {}

    /**
     * @throws \Exception
     */
    public function __invoke(Message $message, \Closure $next): mixed
    {
        $this->begin->call($this);
        try {
            $result = $next($message);
        } catch (\Exception $e) {
            $this->rollback->call($this, $e);
            throw $e;
        }
        $this->commit->call($this);
        return $result;
    }
}
