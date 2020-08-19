<?php

namespace App\Middleware;

use DI\Container;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class RequestMiddleware
{

    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, RequestHandlerInterface $handler): Response
    {
        $this->container->set('request', $request);
        return $handler->handle($request);
    }
}
