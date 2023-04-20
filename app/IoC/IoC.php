<?php

namespace App\IoC;

use App\Exceptions\NotFoundException;
use App\Interfaces\Container;
use Closure;

class IoC implements Container
{
    private array $bindings;

    public function __construct()
    {
        $this->bindings = [
            'IoC.Register' => fn (string $key, Closure $cb, ...$args) => new RegisterCommand(
                $key,
                fn (string $key, object $obj) => $this->bindings[$key] = $obj,
                $cb,
                $args
            )
        ];
    }

    public function resolve(string $key, mixed ...$args): mixed
    {
        if (!isset($this->bindings[$key]))
            throw new NotFoundException("Зависимость $key не объявлена", 1);

        return $this->bindings[$key](...$args);
    }
}
