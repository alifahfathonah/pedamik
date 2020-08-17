<?php

namespace App\Models;

use PDO;
use PDOException;

class Faculty
{
    private $con;

    public function __construct(PDO $con)
    {
        $this->con = $con;
    }

    public function get()
    {
        try {
            return $this->con->query("SELECT * FROM faculties ORDER BY faculty_code ASC", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function findBy($column, $value, $count = false)
    {
        try {
            $stmt = $this->con->prepare("SELECT * FROM faculties WHERE $column = ?");
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
            $stmt = $this->con->prepare("INSERT INTO faculties (faculty_code, name) VALUES (?, ?)");
            $stmt->bindValue(1, $body['faculty_code']);
            $stmt->bindValue(2, $body['name']);

            return $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function update($body, $facultyCode)
    {
        try {
            $stmt = $this->con->prepare("UPDATE faculties SET faculty_code = ?, name = ? WHERE faculty_code = ?");
            $stmt->bindValue(1, $body['faculty_code']);
            $stmt->bindValue(2, $body['name']);
            $stmt->bindValue(3, $facultyCode);

            return $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->con->prepare("DELETE FROM faculties WHERE faculty_code = ?");
            $stmt->bindValue(1, $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
