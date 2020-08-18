<?php

namespace App\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Models\Lecturer;
use App\Models\Department;
use Psr\Container\ContainerInterface;

class LecturerController extends Controller
{
    protected $department, $lecturer;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->department = new Department($this->db);
        $this->lecturer = new Lecturer($this->db);
    }

    public function index(Request $request, Response $response, $args)
    {
        $lecturers = $this->lecturer->get();

        return $this->view->render($response, 'lecturer/index.twig', compact('lecturers'));
    }

    public function create(Request $request, Response $response, $args)
    {
        return $this->view->render($response, 'lecturer/create.twig', []);
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
        if (trim(empty($body['name']))) $errors[] = 'Nama tidak boleh kosong';
        if (trim(empty($body['nidn']))) $errors[] = 'NIDN tidak boleh kosong';
        if (trim(empty($body['phone_number']))) $errors[] = 'Nomor Telepon tidak boleh kosong';
        if (trim(empty($body['gender']))) $errors[] = 'jenis Kelamin tidak boleh kosong';
        if (trim(empty($body['birth_date']))) $errors[] = 'Tanggal Lahir tidak boleh kosong';
        if (trim(empty($body['address']))) $errors[] = 'Alamat tidak boleh kosong';

        if (count($errors) > 0) {
            $this->flashMessage('Error!', 'warning', $errors);

            // input history
            $this->c->get('flash')->addMessage('input', $body);

            return $this->redirect($response, route('lecturer.create'));
        }

        $lecturer = $this->lecturer->findBy('L.nidn', $body['nidn'], true);

        if ($lecturer) {
            $this->flashMessage('Error!', 'warning', ['NIDN sudah digunakan']);

            // input history
            $this->c->get('flash')->addMessage('input', $body);

            return $this->redirect($response, route('lecturer.create'));
        }

        $this->lecturer->insert($body);

        $this->flashMessage('Sukses!', 'success', ['Berhasil menambahkan Dosen baru']);
        return $this->redirect($response, route('lecturer.index'));
    }

    public function update(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();
        $errors = [];
        if (trim(empty($body['name']))) $errors[] = 'Nama tidak boleh kosong';
        if (trim(empty($body['nidn']))) $errors[] = 'NIDN tidak boleh kosong';
        if (trim(empty($body['phone_number']))) $errors[] = 'Nomor Telepon tidak boleh kosong';
        if (trim(empty($body['gender']))) $errors[] = 'jenis Kelamin tidak boleh kosong';
        if (trim(empty($body['birth_date']))) $errors[] = 'Tanggal Lahir tidak boleh kosong';
        if (trim(empty($body['address']))) $errors[] = 'Alamat tidak boleh kosong';

        if (count($errors) > 0) {
            $this->flashMessage('Error!', 'warning', $errors);

            // input history
            $this->c->get('flash')->addMessage('input', $body);

            return $this->redirect($response, route('lecturer.edit', ['id' => $args['id']]));
        }

        $lecturer = $this->lecturer->findBy('L.nidn', $body['nidn']);

        if ($lecturer) {
            if ($lecturer->id !== $args['id']) {
                $this->flashMessage('Error!', 'warning', ['NIDN sudah digunakan']);

                // input history
                $this->c->get('flash')->addMessage('input', $body);

                return $this->redirect($response, route('lecturer.edit', ['id' => $args['id']]));
            }
        }

        $this->lecturer->update($body, $args['id']);

        $this->flashMessage('Sukses!', 'success', ['Berhasil menyimpan perubahan dosen']);
        return $this->redirect($response, route('lecturer.edit', ['id' => $args['id']]));
    }


    public function destroy(Request $request, Response $response, $args)
    {
        $lecturer = $this->lecturer->findBy('L.id', $args['id']);

        if (!$lecturer) return $this->redirect($response, route('lecturer.index'));

        $this->lecturer->delete($args['id']);

        $this->flashMessage('Sukses!', 'success', ['Berhasil menghapus dosen']);
        return $this->redirect($response, route('lecturer.index'));
    }
}
