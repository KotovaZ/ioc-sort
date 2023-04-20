<?php

namespace App\Interfaces;

interface Container
{
    public function resolve(string $key, mixed ...$args): mixed;
}
