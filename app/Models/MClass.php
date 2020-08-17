<?php

namespace App\Models;

use PDO;
use PDOException;

class MClass
{
    private $con;

    public function __construct(PDO $con)
    {
        $this->con = $con;
    }

    public function get()
    {
        try {
            return $this->con->query("SELECT C.*, D.name AS department_name, F.name AS faculty_name FROM classes AS C INNER JOIN departments AS D ON C.department_code = D.department_code INNER JOIN faculties AS F ON F.faculty_code = D.faculty_code ORDER BY C.name,C.semester ASC", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function findBy($column, $value, $count = false)
    {
        try {
            $stmt = $this->con->prepare("SELECT C.*, D.name AS department_name, F.name AS faculty_name, F.faculty_code FROM classes AS C INNER JOIN departments AS D ON C.department_code = D.department_code INNER JOIN faculties AS F ON F.faculty_code = D.faculty_code  WHERE $column = ? ORDER BY C.name,C.semester ASC");
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
            $stmt = $this->con->prepare("INSERT INTO classes (department_code, name, semester) VALUES (?, ?, ?)");
            $stmt->bindValue(1, $body['department_code']);
            $stmt->bindValue(2, $body['name']);
            $stmt->bindValue(3, $body['semester']);

            return $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function update($body, $id)
    {
        try {
            $stmt = $this->con->prepare("UPDATE classes SET department_code = ?, name = ?, semester = ? WHERE id = ?");
            $stmt->bindValue(1, $body['department_code']);
            $stmt->bindValue(2, $body['name']);
            $stmt->bindValue(3, $body['semester']);
            $stmt->bindValue(4, $id);

            return $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->con->prepare("DELETE FROM classes WHERE id = ?");
            $stmt->bindValue(1, $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
