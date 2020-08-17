<?php

namespace App\Models;

use PDO;
use PDOException;

class Student
{
    private $con;

    public function __construct(PDO $con)
    {
        $this->con = $con;
    }

    public function get($search = [])
    {
        try {
            $query = "SELECT S.*, U.email, U.username, U.password, D.name AS department_name, F.faculty_code, F.name AS faculty_name FROM students AS S INNER JOIN users AS U ON U.id = S.user_id INNER JOIN departments AS D ON D.department_code = S.department_code INNER JOIN faculties AS F ON F.faculty_code = D.faculty_code";

            $idx = 0;
            foreach ($search as $col => $val) {
                if ($idx < 1) {
                    $query .= " WHERE $col = ? ";
                } else {
                    $query .= " OR $col = ?";
                }

                $idx++;
            }

            return $this->con->query($query . " ORDER BY S.nim ASC", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function findBy($column, $value, $count = false)
    {
        try {
            $stmt = $this->con->prepare("SELECT S.*, U.email, U.username, U.password, D.faculty_code FROM students AS S INNER JOIN users AS U ON U.id = S.user_id INNER JOIN departments AS D ON D.department_code = S.department_code WHERE $column = ? ORDER BY nim ASC");
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
            $password = password_hash(date('dmY', strtotime($body['birth_date'])), PASSWORD_DEFAULT);
            $stmt = $this->con->prepare("INSERT INTO users (email, username, password) VALUES (?,?,?)");
            $stmt->bindValue(1, $body['email']);
            $stmt->bindValue(2, $body['nim']);
            $stmt->bindValue(3, $password);
            $stmt->execute();

            $uId = $this->con->lastInsertId();

            $stmt = $this->con->prepare("INSERT INTO students (user_id, department_code, nim, phone_number, name, gender, birth_date, birth_place, address, degree) VALUES (?, ?, ?, ? ,?, ?, ?, ?, ?, ?)");

            $stmt->bindValue(1, $uId);
            $stmt->bindValue(2, $body['department_code']);
            $stmt->bindValue(3, $body['nim']);
            $stmt->bindValue(4, $body['phone_number']);
            $stmt->bindValue(5, $body['name']);
            $stmt->bindValue(6, $body['gender']);
            $stmt->bindValue(7, date('Y-m-d', strtotime($body['birth_date'])));
            $stmt->bindValue(8, $body['birth_place']);
            $stmt->bindValue(9, $body['address']);
            $stmt->bindValue(10, $body['degree']);

            return $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function update($body, $id)
    {
        try {
            $student = $this->findBy('S.id', $id);
            $user = new User($this->con);

            // update user
            // if ($body['password']) {
            //     $password = password_hash(date('dmY', strtotime($body['birth_date'])), PASSWORD_DEFAULT);
            //     $user->updatePassword($password, $student->user_id);
            // }

            $user->update([
                'email' => $body['email'],
                'username' => $body['nim'],
            ], $student->user_id);

            // update student
            $stmt = $this->con->prepare("UPDATE students SET department_code = ?, nim = ?, phone_number = ?, name = ?, gender = ?, birth_date = ?, birth_place = ?, address = ?, degree = ? WHERE id = ?");
            $stmt->bindValue(1, $body['department_code']);
            $stmt->bindValue(2, $body['nim']);
            $stmt->bindValue(3, $body['phone_number']);
            $stmt->bindValue(4, $body['name']);
            $stmt->bindValue(5, $body['gender']);
            $stmt->bindValue(6, date('Y-m-d', strtotime($body['birth_date'])));
            $stmt->bindValue(7, $body['birth_place']);
            $stmt->bindValue(8, $body['address']);
            $stmt->bindValue(9, $body['degree']);
            $stmt->bindValue(10, $id);

            return $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $student = $this->findBy('S.id', $id);
            $user = new User($this->con);
            $stmt = $this->con->prepare("DELETE FROM students WHERE id = ?");
            $stmt->bindValue(1, $id);
            $stmt->execute();

            $user->delete($student->user_id);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
