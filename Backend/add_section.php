<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DB2";

$conn = new mysqli($servername, $username, $password, $dbname);

// TODO: Assign the input to variables
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];
    $section_id = $_POST['section_id'];
    $semester = $_POST['semester'];
    $year = $_POST['year'];
    $instructor_id = $_POST['instructor_id'];
    $classroom_id = $_POST['classroom_id'];
    $time_slot_id = $_POST['time_slot_id'];

    // TODO: check if time slot has two sections already scheduled for
    $sql = "SELECT COUNT(*) AS count FROM section WHERE time_slot_id = '$time_slot_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    
    // If less than two sections allocated to the same time slot
    if ($row['count'] < 2) {
        // TODO: check if the sectionv id is already being used for another section
        $sql_section = "SELECT COUNT(*) AS count FROM section WHERE section_id = '$section_id'";
        $result_section = $conn->query($sql_section);
        $row_section = $result_section->fetch_assoc();
        
        // if section is not used
        if ($row_section['count'] == 0) {
            // TOFO: check if the instructor is already teaching two secton
            $sql_instructor = "SELECT COUNT(*) AS count FROM section WHERE instructor_id = '$instructor_id'";
            $result_instructor = $conn->query($sql_instructor);
            $row_instructor = $result_instructor->fetch_assoc();

            // if instructor is teaching <2 sections
            if ($row_instructor['count'] < 2) {
               // Check if the new time slot is consecutive with the instructor's existing section
               $sql_time = "SELECT time_slot_id FROM section WHERE instructor_id = '$instructor_id'";
               $result_time = $conn->query($sql_time);
               $consecutive = ($row_instructor['count'] == 0); // Allow first assignment

               $time_slot_order = ['TS1', 'TS2', 'TS3', 'TS4', 'TS5'];
               $existing_slots = [];

               while ($row_time = $result_time->fetch_assoc()) {
                   $existing_slot = $row_time['time_slot_id'];
                   $existing_slots[] = $existing_slot;
               }

               if ($consecutive) {
                   $consecutive = true;
               } else {
                   foreach ($existing_slots as $existing_slot) {
                       $existing_index = array_search($existing_slot, $time_slot_order);
                       $new_index = array_search($time_slot_id, $time_slot_order);

                       if (abs($existing_index - $new_index) == 1) {
                           $consecutive = true;
                           break;
                       }
                   }
               }

               if ($consecutive) {
                   $sql_insert = "INSERT INTO section (course_id, section_id, semester, year, instructor_id, classroom_id, time_slot_id) 
                                  VALUES ('$course_id', '$section_id', '$semester', '$year', '$instructor_id', '$classroom_id', '$time_slot_id')";
                   $conn->query($sql_insert);
               } 
           }
       }
   }
}


header("Location: main.html");
$conn->close();
?>




