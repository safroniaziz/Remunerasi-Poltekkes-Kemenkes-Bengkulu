<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;

class OrMiddleware
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle($request, Closure $next, ...$middlewares)
    {
        foreach ($middlewares as $middleware) {
            $response = $this->app->make($middleware)->handle($request, $next);
            if ($response !== null) {
                return $response;
            }
        }

        return $next($request);
    }
}
