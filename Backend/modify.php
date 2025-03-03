<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DB2";

$conn = new mysqli($servername, $username, $password, $dbname);

// TODO: Assign the input to variables
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST["student_id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $dept_name = $_POST["dept_name"];

    if ($dept_name != "Miner School of Computer & Information Sciences") {
        header("Location: main.html");
        echo "Invalid Department name";
    }

    // TODO: Update the student's data
    $sql = "UPDATE student 
            SET name = '$name', email = '$email', dept_name = '$dept_name' 
            WHERE student_id = '$student_id'";
    
     $conn->query($sql);
}

// TODO: Redirect to homepaeg
header("Location: main.html");
$conn->close();
?>
