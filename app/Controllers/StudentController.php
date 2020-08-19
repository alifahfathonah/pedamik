<?php

namespace App\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Models\Department;
use App\Models\Student;
use Psr\Container\ContainerInterface;

class StudentController extends Controller
{
    protected $department, $student;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->department = new Department($this->db);
        $this->student = new Student($this->db);
    }

    public function index(Request $request, Response $response, $args)
    {
        $students = $this->student->get();
        return $this->view->render($response, 'student/index.twig', compact('students'));
    }

    public function create(Request $request, Response $response, $args)
    {
        $departments = $this->department->get();

        $data = [];
        foreach ($departments as $department) {
            $data[$department->faculty_code][] = $department;
        }

        return $this->view->render($response, 'student/create.twig', compact('data'));
    }

    public function edit(Request $request, Response $response, $args)
    {
        $departments = $this->department->get();

        $data = [];
        foreach ($departments as $department) {
            $data[$department->faculty_code][] = $department;
        }

        $student = $this->student->findBy('S.id', $args['id']);

        return $this->view->render($response, 'student/edit.twig', compact('student', 'data'));
    }

    public function store(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();

        $errors = [];
        if (trim(empty($body['department_code']))) $errors[] = 'Kode Jurusan tidak boleh kosong';
        if (trim(empty($body['name']))) $errors[] = 'Nama tidak boleh kosong';
        if (trim(empty($body['nim']))) $errors[] = 'NIM tidak boleh kosong';
        if (trim(empty($body['phone_number']))) $errors[] = 'Nomor Telepon tidak boleh kosong';
        if (trim(empty($body['gender']))) $errors[] = 'jenis Kelamin tidak boleh kosong';
        if (trim(empty($body['birth_place']))) $errors[] = 'Tempat Lahir tidak boleh kosong';
        if (trim(empty($body['birth_date']))) $errors[] = 'Tanggal Lahir tidak boleh kosong';
        if (trim(empty($body['degree']))) $errors[] = 'Jenjang tidak boleh kosong';
        if (trim(empty($body['address']))) $errors[] = 'Alamat tidak boleh kosong';

        if (count($errors) > 0) {
            $this->flashMessage('Error!', 'warning', $errors);

            // input history
            $this->c->get('flash')->addMessage('input', $body);

            return $this->redirect($response, route('student.create'));
        }

        $student = $this->student->findBy('nim', $body['nim'], true);

        if ($student) {
            $this->flashMessage('Error!', 'warning', ['NIM sudah digunakan']);

            // input history
            $this->c->get('flash')->addMessage('input', $body);

            return $this->redirect($response, route('student.create'));
        }

        $this->student->insert($body);

        $this->flashMessage('Sukses!', 'success', ['Berhasil menambahkan Mahasiswa baru.', 'Nama Pengguna menggunakan NIM', 'Kata sandi default menggunakan tanggal lahir ddmmyyyy']);
        return $this->redirect($response, route('student.index'));
    }

    public function update(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();
        $errors = [];
        if (trim(empty($body['department_code']))) $errors[] = 'Kode Jurusan tidak boleh kosong';
        if (trim(empty($body['name']))) $errors[] = 'Nama tidak boleh kosong';
        if (trim(empty($body['nim']))) $errors[] = 'NIM tidak boleh kosong';
        if (trim(empty($body['phone_number']))) $errors[] = 'Nomor Telepon tidak boleh kosong';
        if (trim(empty($body['gender']))) $errors[] = 'jenis Kelamin tidak boleh kosong';
        if (trim(empty($body['birth_place']))) $errors[] = 'Tempat Lahir tidak boleh kosong';
        if (trim(empty($body['birth_date']))) $errors[] = 'Tanggal Lahir tidak boleh kosong';
        if (trim(empty($body['degree']))) $errors[] = 'Jenjang tidak boleh kosong';
        if (trim(empty($body['address']))) $errors[] = 'Alamat tidak boleh kosong';

        if (count($errors) > 0) {
            $this->flashMessage('Error!', 'warning', $errors);

            // input history
            $this->c->get('flash')->addMessage('input', $body);

            return $this->redirect($response, route('student.edit', ['id' => $args['id']]));
        }

        $student = $this->student->findBy('S.nim', $body['nim']);

        if ($student) {
            if ($student->id !== $args['id']) {
                $this->flashMessage('Error!', 'warning', ['NIM sudah digunakan']);

                // input history
                $this->c->get('flash')->addMessage('input', $body);

                return $this->redirect($response, route('student.edit', ['id' => $args['id']]));
            }
        }

        $this->student->update($body, $args['id']);

        $this->flashMessage('Sukses!', 'success', ['Berhasil menyimpan Mahasiswa']);
        return $this->redirect($response, route('student.edit', ['id' => $args['id']]));
    }


    public function destroy(Request $request, Response $response, $args)
    {
        $student = $this->student->findBy('S.id', $args['id']);

        if (!$student) return $this->redirect($response, route('student.index'));

        $this->student->delete($args['id']);

        $this->flashMessage('Sukses!', 'success', ['Berhasil menghapus mahasiswa']);
        return $this->redirect($response, route('student.index'));
    }
}
