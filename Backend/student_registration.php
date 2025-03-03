<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DB2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST["student_id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $dept_name = $_POST["dept_name"];

    $check_dept_name = "SELECT dept_name FROM department WHERE dept_name = '$dept_name'";
    $result = $conn->query($check_dept_name);

    if ($result->num_rows == 0) {
        $dept_name = "NULL";
    }

    $sql = "INSERT INTO student (student_id, name, email, dept_name) 
            VALUES ('$student_id', '$name', '$email', $dept_name)";

    $conn->query($sql);
}

header("Location: main.html");

$conn->close();
?>
