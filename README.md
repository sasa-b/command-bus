# Message Bus Pattern 

Colloquially more known as **Command Bus** pattern, but the library makes a distinction between **Commands** and **Queries** and allows you to 
enforce no return values in Command Handlers to keep you in line with [CQRS pattern](https://martinfowler.com/bliki/CQRS.html).

This is a **stand-alone library**, the only two dependencies being the [PSR-11 Container](https://www.php-fig.org/psr/psr-11/) and [PSR-3 Log](https://www.php-fig.org/psr/psr-3/) interfaces to allow for better 
interoperability.

## Core Concepts

### Identity
Each _Command_ or _Query_ and their respective _Response_ object combo will be assigned a unique Identity, e.g. a _Command,_ and its respective _Response_ object will have and identity of `00000001`. 
This can be useful for logging, auditing or debugging purposes. 

The default Identity generation strategy is a simple `SasaB\CommandBus\Identity\RandomString` generator to keep the external dependencies to a minimum. To use something else you could require a library like https://github.com/ramsey/uuid and implement the `\SasaB\CommandBus\Identity`.
```php
use SasaB\CommandBus\Identity;

class UuidIdentity implements Identity
{
    public function generate() : string
    {
        return Uuid::uuid7()->toString();
    }
}
```

### Handler Mapping Strategy
1. **MapByName** - this strategy takes into account the [FQN](https://www.php.net/manual/en/language.namespaces.rules.php) and requires a _Command_ or _Query_ suffix in the class name. 
For example an `FindPostByIdQuery` will get mapped to `FindPostByIdHandler` or a `SavePostCommand` will get mapped to `SavePostHandler`.
2. **MapByAttribute** - this strategy uses PHP attributes, add either `#[IsCommand(handler: SavePostHandler::class)]` or `#[IsQuery(handler: FindPostByIdHandler::class)]` to your Command/Query class. The `handler` parameter name can be omitted, it's up to your personal preference.
3. **Custom** - if you want to create your own custom mapping strategy you can do so by implementing the `SasaB\CommandBus\Mapper` interface.

### Middleware
Each command will be passed through a chain of Middlewares. By the default the chain is empty, but the library does offer 
some Middleware out of the box:
* **EventMiddleware** - raises events before and after handling a command or query, and on failure
* **TransactionMiddleware** - runs individual _Commands_ or _Queries_ in a Transaction, `begin`, `commit` and `rollback` steps are plain `\Closure` objects, so you can use whichever ORM or Persistence approach you prefer. 
* **EmptyResponseMiddleware** - throws an Exception if anything aside from null is returned in _Command_ responses to enforce the _Command-Query Segregation_
* **ImmutableResponseMiddleware** - throws an Exception if you have properties without _readonly_ modifier defined on your response objects

### Event
If you add the `SasaB\CommandBus\Middleware\EventMiddleware` you will be able to subscribe to the following events:
* 

### Response Types

## Getting Started

### Using with Symfony Framework

## Development


### Style Guide
Library follows the [PSR-12 standard](https://www.php-fig.org/psr/psr-12/).

### TO DO:
1. Add PSR Cache interface and implementation for caching responses
