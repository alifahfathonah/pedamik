<?php

namespace App\Controllers;

use Slim\Psr7\Request;
use App\Models\Faculty;
use Slim\Psr7\Response;
use App\Models\Department;
use App\Models\MClass;
use Psr\Container\ContainerInterface;

class ClassController extends Controller
{
    protected $department, $class;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->department = new Department($this->db);
        $this->faculty = new Faculty($this->db);
        $this->class = new MClass($this->db);
    }

    public function index(Request $request, Response $response, $args)
    {
        $classes = $this->class->get();
        return $this->view->render($response, 'class/index.twig', compact('classes'));
    }

    public function create(Request $request, Response $response, $args)
    {
        $departments = $this->department->get();

        $data = [];
        foreach ($departments as $department) {
            $data[$department->faculty_code][] = $department;
        }

        return $this->view->render($response, 'class/create.twig', compact('data'));
    }

    public function edit(Request $request, Response $response, $args)
    {
        $departments = $this->department->get();

        $data = [];
        foreach ($departments as $department) {
            $data[$department->faculty_code][] = $department;
        }

        $class = $this->class->findBy('C.id', $args['id']);
        return $this->view->render($response, 'class/edit.twig', compact('class', 'data'));
    }

    public function store(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();

        $errors = [];
        if (trim(empty($body['department_code']))) $errors[] = 'Kode Jurusan tidak boleh kosong';
        if (trim(empty($body['faculty_code']))) $errors[] = 'Fakultas tidak boleh kosong';
        if (trim(empty($body['semester']))) $errors[] = 'Semester tidak boleh kosong';
        if (trim(empty($body['name']))) $errors[] = 'Nama Nama tidak boleh kosong';

        if (count($errors) > 0) {
            $this->flashMessage('Error!', 'warning', $errors);

            // input history
            $this->c->get('flash')->addMessage('input', $body);

            return $this->redirect($response, route('class.create'));
        }

        $this->class->insert($body);

        $this->flashMessage('Sukses!', 'success', ['Berhasil menambahkan Kelas baru']);
        return $this->redirect($response, route('class.index'));
    }

    public function update(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();
        $errors = [];
        if (trim(empty($body['department_code']))) $errors[] = 'Kode Jurusan tidak boleh kosong';
        if (trim(empty($body['faculty_code']))) $errors[] = 'Fakultas tidak boleh kosong';
        if (trim(empty($body['semester']))) $errors[] = 'Semester tidak boleh kosong';
        if (trim(empty($body['name']))) $errors[] = 'Nama Nama tidak boleh kosong';

        if (count($errors) > 0) {
            $this->flashMessage('Error!', 'warning', $errors);

            // input history
            $this->c->get('flash')->addMessage('input', $body);

            return $this->redirect($response, route('class.edit', ['id' => $args['id']]));
        }

        $this->class->update($body, $args['id']);

        $this->flashMessage('Sukses!', 'success', ['Berhasil menyimpan Kelas']);
        return $this->redirect($response, route('class.edit', ['id' => $args['id']]));
    }


    public function destroy(Request $request, Response $response, $args)
    {
        $class = $this->class->findBy('id', $args['id']);

        if (!$class) return $this->redirect($response, route('class.index'));

        $this->class->delete($args['id']);

        $this->flashMessage('Sukses!', 'success', ['Berhasil menghapus Kelas']);
        return $this->redirect($response, route('class.index'));
    }
}
