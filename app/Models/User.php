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

    public function findUserBy($column, $value, $count = false)
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
}
