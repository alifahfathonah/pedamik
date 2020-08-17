<?php

namespace App\Models;

use PDO;
use PDOException;

class User
{

    private $con;

    public function __construct(PDO $con)
    {
        $this->con = $con;
    }

    public function findBy($column, $value, $count = false)
    {
        try {
            $stmt = $this->con->prepare("SELECT * FROM users WHERE $column = ?");
            $stmt->bindParam(1, $value);
            $stmt->execute();

            if ($count && $stmt->rowCount() < 1) return null;

            $res = $stmt->fetchAll(PDO::FETCH_OBJ);

            if (count($res) === 1) $res = $res[0];

            return $res;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function updatePassword($password, $id)
    {
        try {
            $stmt = $this->con->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->bindValue(1, $password);
            $stmt->bindValue(2, $id);

            return $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function update($body, $id)
    {
        try {
            $stmt = $this->con->prepare("UPDATE users SET email = ?, username = ? WHERE id = ?");
            $stmt->bindValue(1, $body['email']);
            $stmt->bindValue(2, $body['username']);
            $stmt->bindValue(3, $id);

            return $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->con->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bindValue(1, $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
