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

    if ($dept_name != "Miner School of Computer & Information Sciences") {
        header("Location: main.html");
        echo "Invalid Department name";
    }

    $sql = "INSERT INTO student (student_id, name, email, dept_name) 
            VALUES ('$student_id', '$name', '$email', '$dept_name')";

    $conn->query($sql);
}

header("Location: main.html");
exit;

$conn->close();
?>
