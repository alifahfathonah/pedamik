<?php

namespace App\Models;

use PDO;
use PDOException;

class Department
{
    private $con;

    public function __construct(PDO $con)
    {
        $this->con = $con;
    }

    public function get()
    {
        try {
            return $this->con->query("SELECT D.department_code, D.faculty_code, F.name AS faculty_name, D.name AS department_name FROM departments AS D INNER JOIN faculties AS F ON F.faculty_code = D.faculty_code ORDER BY D.faculty_code ASC", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function findBy($column, $value, $count = false)
    {
        try {
            $stmt = $this->con->prepare("SELECT * FROM departments WHERE $column = ?");
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
            $stmt = $this->con->prepare("INSERT INTO departments (department_code, faculty_code, name) VALUES (?, ?, ?)");
            $stmt->bindValue(1, $body['department_code']);
            $stmt->bindValue(2, $body['faculty_code']);
            $stmt->bindValue(3, $body['name']);

            return $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function update($body, $departmentCode)
    {
        try {
            $stmt = $this->con->prepare("UPDATE departments SET department_code = ?, faculty_code = ?, name = ? WHERE department_code = ?");
            $stmt->bindValue(1, $body['department_code']);
            $stmt->bindValue(2, $body['faculty_code']);
            $stmt->bindValue(3, $body['name']);
            $stmt->bindValue(4, $departmentCode);

            return $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->con->prepare("DELETE FROM departments WHERE department_code = ?");
            $stmt->bindValue(1, $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
