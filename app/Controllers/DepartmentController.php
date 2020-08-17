<?php

namespace App\Controllers;

use Slim\Psr7\Request;
use App\Models\Faculty;
use Slim\Psr7\Response;
use App\Models\Department;
use Psr\Container\ContainerInterface;

class DepartmentController extends Controller
{
    protected $department, $faculty;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->department = new Department($this->db);
        $this->faculty = new Faculty($this->db);
    }

    public function index(Request $request, Response $response, $args)
    {
        $departments = $this->department->get();
        return $this->view->render($response, 'department/index.twig', compact('departments'));
    }

    public function create(Request $request, Response $response, $args)
    {
        $faculties = $this->faculty->get();
        return $this->view->render($response, 'department/create.twig', compact('faculties'));
    }

    public function edit(Request $request, Response $response, $args)
    {
        $faculties = $this->faculty->get();
        $department = $this->department->findBy('department_code', $args['id']);
        return $this->view->render($response, 'department/edit.twig', compact('department', 'faculties'));
    }

    public function store(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();
        $errors = [];
        if (trim(empty($body['department_code']))) $errors[] = 'Kode Jurusan tidak boleh kosong';
        if (trim(empty($body['faculty_code']))) $errors[] = 'Fakultas tidak boleh kosong';
        if (trim(empty($body['name']))) $errors[] = 'Nama Jurusan tidak boleh kosong';

        if (count($errors) > 0) {
            $this->flashMessage('Error!', 'warning', $errors);

            // input history
            $this->c->get('flash')->addMessage('input', $body);

            return $this->redirect($response, route('department.create'));
        }

        $department = $this->department->findBy('department_code', $body['department_code'], true);

        if ($department) {
            $this->flashMessage('Error!', 'warning', ['Kode Jurusan sudah digunakan']);

            // input history
            $this->c->get('flash')->addMessage('input', $body);

            return $this->redirect($response, route('department.create'));
        }

        $this->department->insert($body);

        $this->flashMessage('Sukses!', 'success', ['Berhasil menambahkan Jurusan baru']);
        return $this->redirect($response, route('department.index'));
    }

    public function update(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();
        $errors = [];
        if (trim(empty($body['department_code']))) $errors[] = 'Kode Jurusan tidak boleh kosong';
        if (trim(empty($body['faculty_code']))) $errors[] = 'Fakultas tidak boleh kosong';
        if (trim(empty($body['name']))) $errors[] = 'Nama Jurusan tidak boleh kosong';

        if (count($errors) > 0) {
            $this->flashMessage('Error!', 'warning', $errors);

            // input history
            $this->c->get('flash')->addMessage('input', $body);

            return $this->redirect($response, route('department.edit', ['id' => $args['id']]));
        }

        $department = $this->department->findBy('department_code', $body['department_code']);

        if ($department) {
            if ($department->department_code !== $args['id']) {
                $this->flashMessage('Error!', 'warning', ['Kode Jurusan sudah digunakan']);

                // input history
                $this->c->get('flash')->addMessage('input', $body);

                return $this->redirect($response, route('department.edit', ['id' => $args['id']]));
            }
        }

        $this->department->update($body, $department->department_code ?? $args['id']);

        $this->flashMessage('Sukses!', 'success', ['Berhasil menyimpan Jurusan baru']);
        return $this->redirect($response, route('department.edit', ['id' => $body['department_code']]));
    }


    public function destroy(Request $request, Response $response, $args)
    {
        $department = $this->department->findBy('department_code', $args['id']);

        if (!$department) return $this->redirect($response, route('department.index'));

        $this->department->delete($args['id']);

        $this->flashMessage('Sukses!', 'success', ['Berhasil menghapus Jurusan']);
        return $this->redirect($response, route('department.index'));
    }
}
