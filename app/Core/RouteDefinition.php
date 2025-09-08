<?php

namespace App\Core;

class RouteDefinition
{
    private string $method;
    private string $path;
    private array $handler;
    private string $regex;
    private array $middleware = [];

    public function __construct(string $method, string $path, callable|array $handler)
    {
        $this->method = $method;
        $this->path = $path;
        $this->handler = $handler;
        $this->regex = $this->convertPathToRegex($path);
    }

    public function middleware(array $middleware): self
    {
        $this->middleware = $middleware;
        return $this;
    }

    public function getRegex(): string
    {
        return $this->regex;
    }

    public function getHandler(): callable|array
    {
        return $this->handler;
    }

    public function getMiddleware(): array
    {
        return $this->middleware;
    }

    private function convertPathToRegex(string $path): string
    {
        $regex = preg_replace('#\{[^/]+}#', '([^/]+)', $path);
        return '#^' . $regex . '$#';
    }
}