<?php
// Assuming you have included the necessary PHP code for database connection
$con = mysqli_connect("localhost", "root", "", "scoutproject");
if (!$con) {
  die("Could not connect to the database");
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create-course'])) {
    // Get form input values
    $courseName = $_POST['course-name'];
    $startDate = $_POST['start-date'];
    $endDate = $_POST['end-date'];
    $location = $_POST['location'];
    $status = $_POST['status'];
    $instructor = $_POST['instructor'];

    // Convert the course name to lowercase
    $courseNameLower = strtolower($courseName);

    // Check if the course already exists
    $stmt = $con->prepare("SELECT * FROM trainingcourses WHERE LOWER(name) = ?");
    $stmt->bind_param('s', $courseNameLower);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Course already exists.";
    } else {
        // Prepare and execute the INSERT statement
        $stmt = $con->prepare("INSERT INTO trainingcourses (name, start_date, end_date, location, status, instructor) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssss', $courseName, $startDate, $endDate, $location, $status, $instructor);
        $result = $stmt->execute();

        if ($result) {
            echo "Course created and data inserted successfully.";
        } else {
            echo "Error: " . $con->error;
        }
    }

    $stmt->close();
}

$con->close();
?>
