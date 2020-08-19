<?php

namespace App\Controllers;

use App\Models\Faculty;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Psr\Container\ContainerInterface;

class FacultyController extends Controller
{
    protected $faculty;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->faculty = new Faculty($this->db);
    }

    public function index(Request $request, Response $response, $args)
    {
        $faculties = $this->faculty->get();

        return $this->view->render($response, 'faculty/index.twig', compact('faculties'));
    }

    public function create(Request $request, Response $response, $args)
    {
        return $this->view->render($response, 'faculty/create.twig', []);
    }

    public function edit(Request $request, Response $response, $args)
    {
        $faculty = $this->faculty->findBy('faculty_code', $args['id']);
        return $this->view->render($response, 'faculty/edit.twig', compact('faculty'));
    }

    public function store(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();
        $errors = [];
        if (trim(empty($body['faculty_code']))) $errors[] = 'Kode Fakultas tidak boleh kosong';
        if (trim(empty($body['name']))) $errors[] = 'Nama Fakultas tidak boleh kosong';

        if (count($errors) > 0) {
            $this->flashMessage('Error!', 'warning', $errors);

            // input history
            $this->c->get('flash')->addMessage('input', $body);

            return $this->redirect($response, route('faculty.create'));
        }

        $faculty = $this->faculty->findBy('faculty_code', $body['faculty_code'], true);

        if ($faculty) {
            $this->flashMessage('Error!', 'warning', ['Kode Fakultas sudah digunakan']);

            // input history
            $this->c->get('flash')->addMessage('input', $body);

            return $this->redirect($response, route('faculty.create'));
        }

        $this->faculty->insert($body);

        $this->flashMessage('Sukses!', 'success', ['Berhasil menambahkan fakultas baru']);
        return $this->redirect($response, route('faculty.index'));
    }

    public function update(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();
        $errors = [];
        if (trim(empty($body['faculty_code']))) $errors[] = 'Kode Fakultas tidak boleh kosong';
        if (trim(empty($body['name']))) $errors[] = 'Nama Fakultas tidak boleh kosong';

        if (count($errors) > 0) {
            $this->flashMessage('Error!', 'warning', $errors);

            // input history
            $this->c->get('flash')->addMessage('input', $body);

            return $this->redirect($response, route('faculty.edit', ['id' => $args['id']]));
        }

        $faculty = $this->faculty->findBy('faculty_code', $body['faculty_code']);

        if ($faculty) {
            if ($faculty->faculty_code !== $args['id']) {
                $this->flashMessage('Error!', 'warning', ['Kode Fakultas sudah digunakan']);

                // input history
                $this->c->get('flash')->addMessage('input', $body);

                return $this->redirect($response, route('faculty.edit', ['id' => $args['id']]));
            }
        }

        $this->faculty->update($body, $faculty->faculty_code ?? $args['id']);

        $this->flashMessage('Sukses!', 'success', ['Berhasil menyimpan fakultas baru']);
        return $this->redirect($response, route('faculty.edit', ['id' => $body['faculty_code']]));
    }


    public function destroy(Request $request, Response $response, $args)
    {
        $faculty = $this->faculty->findBy('faculty_code', $args['id']);

        if (!$faculty) return $this->redirect($response, route('faculty.index'));

        $this->faculty->delete($args['id']);

        $this->flashMessage('Sukses!', 'success', ['Berhasil menghapus fakultas']);
        return $this->redirect($response, route('faculty.index'));
    }
}
