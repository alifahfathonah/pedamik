<?php

$app->get('/', '\App\Controllers\HomeController:home')->setName('home');
$app->get('/login', '\App\Controllers\LoginController:form')->setName('login');
$app->post('/login', '\App\Controllers\LoginController:login');

/** Faculties */
$app->get('/faculty', '\App\Controllers\FacultyController:index')->setName('faculty.index');
$app->get('/faculty/{id}/edit', '\App\Controllers\FacultyController:edit')->setName('faculty.edit');
$app->post('/faculty', '\App\Controllers\FacultyController:store')->setName('faculty.store');
$app->post('/faculty/{id}', '\App\Controllers\FacultyController:update')->setName('faculty.update');
$app->post('/faculty/{id}/destroy', '\App\Controllers\FacultyController:destroy')->setName('faculty.destroy');
$app->get('/faculty/create', '\App\Controllers\FacultyController:create')->setName('faculty.create');

/** Departments */
$app->get('/department', '\App\Controllers\DepartmentController:index')->setName('department.index');
$app->get('/department/{id}/edit', '\App\Controllers\DepartmentController:edit')->setName('department.edit');
$app->post('/department', '\App\Controllers\DepartmentController:store')->setName('department.store');
$app->post('/department/{id}', '\App\Controllers\DepartmentController:update')->setName('department.update');
$app->post('/department/{id}/destroy', '\App\Controllers\DepartmentController:destroy')->setName('department.destroy');
$app->get('/department/create', '\App\Controllers\DepartmentController:create')->setName('department.create');

/** Class */
$app->get('/class', '\App\Controllers\ClassController:index')->setName('class.index');
$app->get('/class/{id}/edit', '\App\Controllers\ClassController:edit')->setName('class.edit');
$app->post('/class', '\App\Controllers\ClassController:store')->setName('class.store');
$app->post('/class/{id}', '\App\Controllers\ClassController:update')->setName('class.update');
$app->post('/class/{id}/destroy', '\App\Controllers\ClassController:destroy')->setName('class.destroy');
$app->get('/class/create', '\App\Controllers\ClassController:create')->setName('class.create');
