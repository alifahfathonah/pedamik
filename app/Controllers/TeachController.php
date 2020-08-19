<?php

namespace App\Controllers;

use App\Models\Course;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Models\Lecturer;
use App\Models\Department;
use App\Models\MClass;
use App\Models\Teach;
use Psr\Container\ContainerInterface;

class TeachController extends Controller
{
    protected $department, $lecturer, $teach, $class, $course;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->department = new Department($this->db);
        $this->lecturer = new Lecturer($this->db);
        $this->course = new Course($this->db);
        $this->class = new MClass($this->db);
        $this->teach = new Teach($this->db);
    }

    public function index(Request $request, Response $response, $args)
    {
        $teaches = $this->teach->lecturerClassList($args['id']);
        $lecturer = $this->lecturer->findBy('L.id', $args['id']);

        return $this->view->render($response, 'lecturer/teach.twig', compact('lecturer', 'teaches'));
    }

    public function create(Request $request, Response $response, $args)
    {
        $departments = $this->department->get();
        $classes = $this->class->get()->fetchAll(\PDO::FETCH_OBJ);
        $courses = $this->course->get()->fetchAll(\PDO::FETCH_OBJ);

        $classes = array_reduce($classes, function ($res, $el) {
            $res[$el->department_code][] = $el;
            return $res;
        }, []);

        $courses = array_reduce($courses, function ($res, $el) {
            $res[$el->department_code][] = $el;
            return $res;
        }, []);

        $data = [];
        foreach ($departments as $department) {
            $data[$department->faculty_code][$department->department_code]['department'] = $department;
            $data[$department->faculty_code][$department->department_code]['class'] = $classes[$department->department_code] ?? [];
            $data[$department->faculty_code][$department->department_code]['courses'] = $courses[$department->department_code] ?? [];
        }

        $lecturer = $this->lecturer->findBy('L.id', $args['id']);

        return $this->view->render($response, 'lecturer/teach-create.twig', compact('data', 'lecturer'));
    }

    public function edit(Request $request, Response $response, $args)
    {
        $lecturer = $this->lecturer->findBy('L.id', $args['id']);

        return $this->view->render($response, 'lecturer/edit.twig', compact('lecturer'));
    }

    public function store(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();

        $errors = [];
        if (trim(empty($body['class_id']))) $errors[] = 'Kelas tidak boleh kosong';
        if (trim(empty($body['course_code']))) $errors[] = 'Mata Kuliah tidak boleh kosong';
        if (trim(empty($body['year']))) $errors[] = 'Tahun ajar tidak boleh kosong';
        if (trim(empty($body['day']))) $errors[] = 'Hari ajar tidak boleh kosong';

        if (count($errors) > 0) {
            $this->flashMessage('Error!', 'warning', $errors);

            // input history
            $this->c->get('flash')->addMessage('input', $body);

            return $this->redirect($response, route('lecturer.teach.create', ['id' => $args['id']]));
        }

        $this->teach->insert(array_merge($body, [
            'lecturer_id' => $args['id'],
        ]));

        $this->flashMessage('Sukses!', 'success', ['Berhasil menambahkan Kelas baru']);
        return $this->redirect($response, route('lecturer.teach', ['id' => $args['id']]));
    }

    public function destroy(Request $request, Response $response, $args)
    {
        $this->teach->delete($args['id']);

        $this->flashMessage('Sukses!', 'success', ['Berhasil menghapus kelas']);

        return $this->redirect($response, route('lecturer.teach', ['id' => $args['id']]));
    }
}
