<?php

namespace App\Controllers;

use App\Models\Course;
use Slim\Psr7\Request;
use App\Models\Faculty;
use Slim\Psr7\Response;
use App\Models\Department;
use App\Models\MClass;
use Psr\Container\ContainerInterface;

class CourseController extends Controller
{
    protected $department, $course;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->department = new Department($this->db);
        $this->course = new Course($this->db);
    }

    public function index(Request $request, Response $response, $args)
    {
        $courses = $this->course->get();
        return $this->view->render($response, 'course/index.twig', compact('courses'));
    }

    public function create(Request $request, Response $response, $args)
    {
        $departments = $this->department->get();

        $data = [];
        foreach ($departments as $department) {
            $data[$department->faculty_code][] = $department;
        }

        return $this->view->render($response, 'course/create.twig', compact('data'));
    }

    public function edit(Request $request, Response $response, $args)
    {
        $departments = $this->department->get();

        $data = [];
        foreach ($departments as $department) {
            $data[$department->faculty_code][] = $department;
        }

        $course = $this->course->findBy('C.course_code', $args['id']);
        return $this->view->render($response, 'course/edit.twig', compact('course', 'data'));
    }

    public function store(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();

        $errors = [];
        if (trim(empty($body['department_code']))) $errors[] = 'Kode Jurusan tidak boleh kosong';
        if (trim(empty($body['faculty_code']))) $errors[] = 'Fakultas tidak boleh kosong';
        if (trim(empty($body['semester']))) $errors[] = 'Semester tidak boleh kosong';
        if (trim(empty($body['name']))) $errors[] = 'Nama Kelas tidak boleh kosong';
        if (trim(empty($body['sks']))) $errors[] = 'SKS tidak boleh kosong';
        if (trim(empty($body['course_code']))) $errors[] = 'Kode Mata Kuliah tidak boleh kosong';

        if (count($errors) > 0) {
            $this->flashMessage('Error!', 'warning', $errors);

            // input history
            $this->c->get('flash')->addMessage('input', $body);

            return $this->redirect($response, route('course.create'));
        }

        $course = $this->course->findBy('course_code', $body['course_code'], true);

        if ($course) {
            $this->flashMessage('Error!', 'warning', ['Kode Mata Kuliah sudah digunakan']);

            // input history
            $this->c->get('flash')->addMessage('input', $body);

            return $this->redirect($response, route('course.create'));
        }

        $this->course->insert($body);

        $this->flashMessage('Sukses!', 'success', ['Berhasil menambahkan Mata Kuliah baru']);
        return $this->redirect($response, route('course.index'));
    }

    public function update(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();
        $errors = [];
        if (trim(empty($body['department_code']))) $errors[] = 'Kode Jurusan tidak boleh kosong';
        if (trim(empty($body['faculty_code']))) $errors[] = 'Fakultas tidak boleh kosong';
        if (trim(empty($body['semester']))) $errors[] = 'Semester tidak boleh kosong';
        if (trim(empty($body['name']))) $errors[] = 'Nama Kelas tidak boleh kosong';

        if (count($errors) > 0) {
            $this->flashMessage('Error!', 'warning', $errors);

            // input history
            $this->c->get('flash')->addMessage('input', $body);

            return $this->redirect($response, route('class.edit', ['id' => $args['id']]));
        }

        $course = $this->course->findBy('course_code', $body['course_code']);

        if ($course) {
            if ($course->course_code !== $args['id']) {
                $this->flashMessage('Error!', 'warning', ['Kode Mata Kuliah sudah digunakan']);

                // input history
                $this->c->get('flash')->addMessage('input', $body);

                return $this->redirect($response, route('course.edit', ['id' => $args['id']]));
            }
        }

        $this->course->update($body, $course->course_code ?? $args['id']);

        $this->flashMessage('Sukses!', 'success', ['Berhasil menyimpan Mata Kuliah']);
        return $this->redirect($response, route('course.edit', ['id' => $body['course_code']]));
    }


    public function destroy(Request $request, Response $response, $args)
    {
        $course = $this->course->findBy('C.course_code', $args['id']);

        if (!$course) return $this->redirect($response, route('course.index'));

        $this->course->delete($args['id']);

        $this->flashMessage('Sukses!', 'success', ['Berhasil menghapus mata Kuliah']);
        return $this->redirect($response, route('course.index'));
    }
}
