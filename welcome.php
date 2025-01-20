<?php
session_start();
if (!isset($_SESSION['student_name'])) {
    header("Location: register.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['student_name']); ?>!</h1>
    <p>You have successfully registered. <a href="logout.php">Logout</a></p>
</body>
</html>
