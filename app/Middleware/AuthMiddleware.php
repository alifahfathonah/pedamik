<?php

namespace App\Middleware;

use DI\Container;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class AuthMiddleware
{
    protected $redirectIfUnAuthenticated = 'login';

    public function __invoke(Request $request, RequestHandlerInterface $handler): Response
    {
        $response = new Response();

        if (isset($_SESSION['auth'])) return $handler->handle($request);
        else return $response->withHeader('Location', route($this->redirectIfUnAuthenticated));
    }
}
