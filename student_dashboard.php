<?php
session_start();
if (!isset($_SESSION['student'])) {
    header('Location: student_login.php');
    exit();
}
include 'db.php';

// Get Student Data
$student_id = $_SESSION['student'];
$sql = "SELECT * FROM students WHERE id='$student_id'";
$result = $conn->query($sql);
$student = $result->fetch_assoc();

// Get Assigned Teacher
$teacher_id = $student['teacher_id'];
$teacher = $conn->query("SELECT first_name, last_name FROM teachers WHERE id='$teacher_id'")->fetch_assoc();

// Get Exams and School Info from the assigned teacher
$exams = $conn->query("SELECT * FROM exams WHERE teacher_id='$teacher_id'");
$school_info = $conn->query("SELECT * FROM school_info WHERE teacher_id='$teacher_id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?> <!-- Navigation einbinden -->

    <div class="container py-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h1 class="card-title">Student Dashboard</h1>
            </div>
            <div class="card-body">
                <h2 class="mb-4">Welcome, <?php echo $student['first_name'] . ' ' . $student['last_name']; ?>!</h2>

                <h3 class="mb-3">Your Information:</h3>
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Username:</strong> <?php echo $student['username']; ?>
                    </li>
                    <li class="list-group-item">
                        <strong>Assigned Teacher:</strong>
                        <?php
                        if ($teacher) {
                            echo $teacher['first_name'] . ' ' . $teacher['last_name'];
                        } else {
                            echo 'Not Assigned';
                        }
                        ?>
                    </li>
                </ul>

                <hr class="my-5">

                <h3 class="mb-3">Exams</h3>
                <ul class="list-group">
                    <?php while ($exam = $exams->fetch_assoc()): ?>
                        <li class="list-group-item">
                            <strong><?php echo $exam['title']; ?></strong><br>
                            <?php echo $exam['description']; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>

                <h3 class="mb-3 mt-5">School Info</h3>
                <ul class="list-group">
                    <?php while ($info = $school_info->fetch_assoc()): ?>
                        <li class="list-group-item">
                            <strong><?php echo $info['title']; ?></strong><br>
                            <?php echo $info['message']; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
            <div class="card-footer text-end">
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>