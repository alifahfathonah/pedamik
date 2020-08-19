
    <?php

    require __DIR__ . '/../vendor/autoload.php';

    $con = mysqli_connect("localhost", "root", "", "10118068_akademik");

    $res = mysqli_query($con, "SELECT * FROM courses");


    while ($data = mysqli_fetch_assoc($res)) {
        var_dump($data);
        echo "<option value=" . $data['course_code'] . ">" . $data['name'] . "</option>";
    }

    ?>
