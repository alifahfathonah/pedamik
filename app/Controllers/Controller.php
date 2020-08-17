<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class Controller
{
    protected $c, $view, $db, $session;

    public function __construct(ContainerInterface $container)
    {
        $this->c = $container;
        $this->db = $this->c->get('db');
        $this->view = $this->c->get('view');
    }

    protected function redirect(Response $response, $url)
    {
        return $response->withHeader('Refresh', '0;url=' . $url);
    }

    public function flashMessage($title, $type, $message)
    {
        $this->c->get('flash')->addMessage('flash_message', [
            'title' => $title,
            'type' => $type,
            'message' => $message,
        ]);
    }
}
