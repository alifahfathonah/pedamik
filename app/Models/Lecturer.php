<?php

namespace App\Models;

use PDO;
use PDOException;

class Lecturer
{
    private $con;

    public function __construct(PDO $con)
    {
        $this->con = $con;
    }

    public function get($search = [])
    {
        try {
            $query = "SELECT L.*, U.email, U.username, U.password FROM lecturers AS L INNER JOIN users AS U ON U.id = L.user_id";

            $idx = 0;
            foreach ($search as $col => $val) {
                if ($idx < 1) {
                    $query .= " WHERE $col = ? ";
                } else {
                    $query .= " OR $col = ?";
                }

                $idx++;
            }

            return $this->con->query($query . " ORDER BY L.name ASC", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function findBy($column, $value, $count = false)
    {
        try {
            $stmt = $this->con->prepare("SELECT L.*, U.email, U.username, U.password FROM lecturers AS L INNER JOIN users AS U ON U.id = L.user_id WHERE $column = ? ORDER BY L.name ASC");
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
            $stmt->bindValue(2, $body['nidn']);
            $stmt->bindValue(3, $password);
            $stmt->execute();

            $uId = $this->con->lastInsertId();

            $stmt = $this->con->prepare("INSERT INTO lecturers (user_id, nidn, phone_number, name, gender, birth_date, address) VALUES (?, ?, ?, ? ,?, ?, ?)");

            $stmt->bindValue(1, $uId);
            $stmt->bindValue(2, $body['nidn']);
            $stmt->bindValue(3, $body['phone_number']);
            $stmt->bindValue(4, $body['name']);
            $stmt->bindValue(5, $body['gender']);
            $stmt->bindValue(6, date('Y-m-d', strtotime($body['birth_date'])));
            $stmt->bindValue(7, $body['address']);

            return $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function update($body, $id)
    {
        try {
            $lecturer = $this->findBy('L.id', $id);
            $user = new User($this->con);

            // update user
            // if ($body['password']) {
            //     $password = password_hash(date('dmY', strtotime($body['birth_date'])), PASSWORD_DEFAULT);
            //     $user->updatePassword($password, $student->user_id);
            // }

            $user->update([
                'email' => $body['email'],
                'username' => $body['nidn'],
            ], $lecturer->user_id);

            // update student
            $stmt = $this->con->prepare("UPDATE lecturers SET nidn = ?, phone_number = ?, name = ?, gender = ?, birth_date = ?, address = ? WHERE id = ?");
            $stmt->bindValue(1, $body['nidn']);
            $stmt->bindValue(2, $body['phone_number']);
            $stmt->bindValue(3, $body['name']);
            $stmt->bindValue(4, $body['gender']);
            $stmt->bindValue(5, date('Y-m-d', strtotime($body['birth_date'])));
            $stmt->bindValue(6, $body['address']);
            $stmt->bindValue(7, $id);

            return $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $lecturer = $this->findBy('L.id', $id);
            $user = new User($this->con);
            $stmt = $this->con->prepare("DELETE FROM lecturers WHERE id = ?");
            $stmt->bindValue(1, $id);
            $stmt->execute();

            $user->delete($lecturer->user_id);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
