<?php

namespace App\Models;

use PDO;
use PDOException;

class Course
{
    private $con;

    public function __construct(PDO $con)
    {
        $this->con = $con;
    }

    public function get()
    {
        try {
            return $this->con->query("SELECT C.*, D.name AS department_name, F.name AS faculty_name, F.faculty_code FROM courses AS C INNER JOIN departments AS D ON D.department_code = C.department_code INNER JOIN faculties AS F ON F.faculty_code = D.faculty_code ORDER BY semester ASC", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function findBy($column, $value, $count = false)
    {
        try {
            $stmt = $this->con->prepare("SELECT C.*, D.name AS department_name, F.name AS faculty_name, F.faculty_code FROM courses AS C INNER JOIN departments AS D ON D.department_code = C.department_code INNER JOIN faculties AS F ON F.faculty_code = D.faculty_code WHERE $column = ? ORDER BY semester ASC");
            $stmt->bindParam(1, $value);
            $stmt->execute();

            if ($count) return $stmt->rowCount() > 0;

            $res = $stmt->fetchAll(PDO::FETCH_OBJ);

            if (count($res) === 1) $res = $res[0];

            return $res;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function insert($body)
    {
        try {
            $stmt = $this->con->prepare("INSERT INTO courses (course_code, department_code, name, semester, sks) VALUES (?, ?, ?, ? ,?)");
            $stmt->bindValue(1, $body['course_code']);
            $stmt->bindValue(2, $body['department_code']);
            $stmt->bindValue(3, $body['name']);
            $stmt->bindValue(4, $body['semester']);
            $stmt->bindValue(5, $body['sks']);

            return $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function update($body, $courseCode)
    {
        try {
            $stmt = $this->con->prepare("UPDATE courses SET course_code = ?, department_code = ?, name = ?, semester = ?, sks = ? WHERE course_code = ?");
            $stmt->bindValue(1, $body['course_code']);
            $stmt->bindValue(2, $body['department_code']);
            $stmt->bindValue(3, $body['name']);
            $stmt->bindValue(4, $body['semester']);
            $stmt->bindValue(5, $body['sks']);
            $stmt->bindValue(6, $courseCode);

            return $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->con->prepare("DELETE FROM courses WHERE course_code = ?");
            $stmt->bindValue(1, $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
