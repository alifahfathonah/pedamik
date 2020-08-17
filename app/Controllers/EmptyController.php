<?php

namespace App\Controllers;

use App\Models\User;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Psr\Container\ContainerInterface;

class EmptyController extends Controller
{
    // optional construct
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }

    public function methodName(Request $request, Response $response, $args)
    {
        //
    }
}
