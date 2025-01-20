<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'student_database');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data safely
    $student_name = isset($_POST['student_name']) ? trim($_POST['student_name']) : '';
    $student_id = isset($_POST['student_id']) ? trim($_POST['student_id']) : '';
    $department = isset($_POST['department']) ? trim($_POST['department']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Validate fields
    if (empty($student_name) || empty($student_id) || empty($department) || empty($password)) {
        echo "All fields are required!";
        exit();
    }

    // Validate Student ID (Only letters and numbers allowed)
    if (!preg_match('/^[A-Za-z0-9]+$/', $student_id)) {
        echo "Student ID can only contain letters and numbers!";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL query to insert data
    $stmt = $conn->prepare("INSERT INTO students (student_name, student_id, department, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $student_name, $student_id, $department, $hashed_password);

    // Execute and check
    if ($stmt->execute()) {
        $_SESSION['student_name'] = $student_name;
        header("Location: welcome.php"); // Redirect to welcome page
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
