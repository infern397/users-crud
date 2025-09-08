<?php

namespace App\Core;

abstract class Middleware
{
    /**
     * @param Request $request
     * @return void
     */
    abstract public function handle(Request $request): void;
}