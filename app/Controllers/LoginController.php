<?php

namespace App\Controllers;

use App\Models\User;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Psr\Container\ContainerInterface;

class LoginController extends Controller
{
    protected $user;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->user = new User($this->db);
    }

    public function form(Request $request, Response $response, $args)
    {
        return $this->view->render($response, 'login.twig', []);
    }

    public function login(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();
        $errors = [];
        if (trim(empty($body['username']))) $errors[] = 'Nama Pengguna tidak boleh kosong';
        if (trim(empty($body['password']))) $errors[] = 'Kata Sandi tidak boleh kosong';

        if (count($errors) > 0) {
            $this->flashMessage('Error!', 'warning', $errors);

            return $this->redirect($response, route('login'));
        }

        $user = $this->user->findUserBy('username', $body['username']);

        if (!$user) {
            $this->flashMessage('Error!', 'warning', ['Nama Pengguna tidak ditemukan']);

            return $this->redirect($response, route('login'));
        }

        if (!password_verify($body['password'], $user->password)) {
            $this->flashMessage('Error!', 'warning', ['Nama Pengguna atau Password salah']);

            return $this->redirect($response, route('login'));
        }

        $_SESSION['auth'] = $user;

        return $this->redirect($response, route('home'));
    }
}
