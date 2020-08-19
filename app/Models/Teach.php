<?php

namespace App\Models;

use PDO;
use PDOException;

class Teach
{
    private $con;

    public function __construct(PDO $con)
    {
        $this->con = $con;
    }

    public function lecturerClassList($id)
    {
        try {
            $stmt = $this->con->prepare("SELECT T.*, C.name AS class_name, C.semester, CS.name AS course_name, CS.semester AS course_semester, CS.sks, D.name AS department_name, F.name AS faculty_name, (select count(id) FROM students_courses AS S WHERE S.teach_id = T.id) as student_amount FROM teaches AS T INNER JOIN classes AS C ON C.id = T.class_id INNER JOIN courses AS CS ON CS.course_code = T.course_code INNER JOIN departments AS D ON D.department_code = C.department_code INNER JOIN faculties AS F ON F.faculty_code = D.faculty_code WHERE T.lecturer_id = ? ORDER BY C.name, C.semester, T.year DESC");
            $stmt->bindParam(1, $id);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function insert($body)
    {
        try {
            $stmt = $this->con->prepare("INSERT INTO teaches (lecturer_id, class_id, course_code, year, day) VALUES (?,?,?,?,?)");
            $stmt->bindValue(1, $body['lecturer_id']);
            $stmt->bindValue(2, $body['class_id']);
            $stmt->bindValue(3, $body['course_code']);
            $stmt->bindValue(4, $body['year']);
            $stmt->bindValue(5, $body['day']);
            return $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->con->prepare("DELETE FROM teaches WHERE id = ?");
            $stmt->bindValue(1, $id);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
