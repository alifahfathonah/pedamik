<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\RoleMiddleware;
use Slim\Routing\RouteCollectorProxy;

$app->get('/', '\App\Controllers\HomeController:home')->setName('home');
$app->get('/login', '\App\Controllers\LoginController:form')->setName('login');
$app->post('/login', '\App\Controllers\LoginController:login');
$app->get('/logout', '\App\Controllers\LoginController:logout')->setName('logout');

$app->group('', function (RouteCollectorProxy $group) {

    $group->group('', function (RouteCollectorProxy $route) {
        /** Faculties */
        $route->get('/faculty', '\App\Controllers\FacultyController:index')->setName('faculty.index');
        $route->get('/faculty/{id}/edit', '\App\Controllers\FacultyController:edit')->setName('faculty.edit');
        $route->post('/faculty', '\App\Controllers\FacultyController:store')->setName('faculty.store');
        $route->post('/faculty/{id}', '\App\Controllers\FacultyController:update')->setName('faculty.update');
        $route->post('/faculty/{id}/destroy', '\App\Controllers\FacultyController:destroy')->setName('faculty.destroy');
        $route->get('/faculty/create', '\App\Controllers\FacultyController:create')->setName('faculty.create');

        /** Departments */
        $route->get('/department', '\App\Controllers\DepartmentController:index')->setName('department.index');
        $route->get('/department/{id}/edit', '\App\Controllers\DepartmentController:edit')->setName('department.edit');
        $route->post('/department', '\App\Controllers\DepartmentController:store')->setName('department.store');
        $route->post('/department/{id}', '\App\Controllers\DepartmentController:update')->setName('department.update');
        $route->post('/department/{id}/destroy', '\App\Controllers\DepartmentController:destroy')->setName('department.destroy');
        $route->get('/department/create', '\App\Controllers\DepartmentController:create')->setName('department.create');

        /** Class */
        $route->get('/class', '\App\Controllers\ClassController:index')->setName('class.index');
        $route->get('/class/{id}/edit', '\App\Controllers\ClassController:edit')->setName('class.edit');
        $route->post('/class', '\App\Controllers\ClassController:store')->setName('class.store');
        $route->post('/class/{id}', '\App\Controllers\ClassController:update')->setName('class.update');
        $route->post('/class/{id}/destroy', '\App\Controllers\ClassController:destroy')->setName('class.destroy');
        $route->get('/class/create', '\App\Controllers\ClassController:create')->setName('class.create');

        /** Course */
        $route->get('/course', '\App\Controllers\CourseController:index')->setName('course.index');
        $route->get('/course/{id}/edit', '\App\Controllers\CourseController:edit')->setName('course.edit');
        $route->post('/course', '\App\Controllers\CourseController:store')->setName('course.store');
        $route->post('/course/{id}', '\App\Controllers\CourseController:update')->setName('course.update');
        $route->post('/course/{id}/destroy', '\App\Controllers\CourseController:destroy')->setName('course.destroy');
        $route->get('/course/create', '\App\Controllers\CourseController:create')->setName('course.create');

        /** Student */
        $route->get('/student', '\App\Controllers\StudentController:index')->setName('student.index');
        $route->get('/student/{id}/edit', '\App\Controllers\StudentController:edit')->setName('student.edit');
        $route->post('/student', '\App\Controllers\StudentController:store')->setName('student.store');
        $route->post('/student/{id}', '\App\Controllers\StudentController:update')->setName('student.update');
        $route->post('/student/{id}/destroy', '\App\Controllers\StudentController:destroy')->setName('student.destroy');
        $route->get('/student/create', '\App\Controllers\StudentController:create')->setName('student.create');

        /** Lecturer */
        $route->get('/lecturer', '\App\Controllers\LecturerController:index')->setName('lecturer.index');
        $route->get('/lecturer/{id}/edit', '\App\Controllers\LecturerController:edit')->setName('lecturer.edit');
        $route->get('/lecturer/{id}/teach', '\App\Controllers\TeachController:index')->setName('lecturer.teach');
        $route->get('/lecturer/{id}/teach/create', '\App\Controllers\TeachController:create')->setName('lecturer.teach.create');
        $route->post('/lecturer/{id}/teach', '\App\Controllers\TeachController:store')->setName('lecturer.teach.store');
        $route->post('/lecturer/{id}/teach/destroy', '\App\Controllers\TeachController:destroy')->setName('lecturer.teach.destroy');
        $route->post('/lecturer', '\App\Controllers\LecturerController:store')->setName('lecturer.store');
        $route->post('/lecturer/{id}', '\App\Controllers\LecturerController:update')->setName('lecturer.update');
        $route->post('/lecturer/{id}/destroy', '\App\Controllers\LecturerController:destroy')->setName('lecturer.destroy');
        $route->get('/lecturer/create', '\App\Controllers\LecturerController:create')->setName('lecturer.create');
    })->add(new RoleMiddleware($group->getContainer(), 'admin'));
})->add(new AuthMiddleware());
