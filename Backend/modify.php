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

    // TODO: Execute the query to get the Department name
    $check_dept_name = "SELECT dept_name FROM department WHERE dept_name = '$dept_name'";
    $result = $conn->query($check_dept_name);

    // TODO: Checkk if the dept exists, and assign it to NULL if it's not
    if ($result->num_rows == 0) {
        $dept_name = NULL;  
    }

    // TODO: Update the student's data
    $sql = "UPDATE student 
            SET name = '$name', email = '$email', dept_name = " . ($dept_name === NULL ? 'NULL' : "'$dept_name'") . " 
            WHERE student_id = '$student_id'";
    
     $conn->query($sql);
}

// TODO: Redirect to homepaeg
header("Location: main.html");
$conn->close();
?>
