<?php

namespace App\Middleware;

use DI\Container;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class RoleMiddleware
{
    protected $redirectTo = 'home';
    protected $role;

    public function __construct(Container $container, $role)
    {
        $this->container = $container;
        $this->role = $role;
    }

    public function __invoke(Request $request, RequestHandlerInterface $handler): Response
    {
        $response = new Response();

        if ($this->container->get('user')->role == $this->role) return $handler->handle($request);
        else return $response->withHeader('Location', route($this->redirectTo));
    }
}
