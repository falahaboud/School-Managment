<?php
session_start();
if (!isset($_SESSION['teacher'])) {
    header('Location: teacher_login.php');
    exit();
}
include 'db.php';

// Get Teacher Data
// Get Teacher Data
$teacher_id = $_SESSION['teacher'];
$sql = "SELECT * FROM teachers WHERE id='$teacher_id'";
$result = $conn->query($sql);
$teacher = $result->fetch_assoc();

// Get Students assigned to this teacher
$students = $conn->query("SELECT * FROM students WHERE teacher_id='$teacher_id'");

// Add Exam
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_exam'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $sql = "INSERT INTO exams (teacher_id, title, description) VALUES ('$teacher_id', '$title', '$description')";
    $conn->query($sql);
}

// Add School Info
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_school_info'])) {
    $title = $_POST['title'];
    $message = $_POST['message'];

    $sql = "INSERT INTO school_info (teacher_id, title, message) VALUES ('$teacher_id', '$title', '$message')";
    $conn->query($sql);
}

// Get Exams and School Info created by this teacher
$exams = $conn->query("SELECT * FROM exams WHERE teacher_id='$teacher_id'");
$school_info = $conn->query("SELECT * FROM school_info WHERE teacher_id='$teacher_id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?> <!-- Navigation einbinden -->

    <div class="container py-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h1 class="card-title">Teacher Dashboard</h1>
            </div>
            <div class="card-body">
                <h2 class="mb-4">Welcome, <?php echo $teacher['first_name'] . ' ' . $teacher['last_name']; ?>!</h2>

                <h3 class="mb-3">Your Students:</h3>
                <ul class="list-group">
                    <?php while ($student = $students->fetch_assoc()): ?>
                        <li class="list-group-item">
                            <?php echo $student['first_name'] . ' ' . $student['last_name']; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>

                <hr class="my-5">

                <h3 class="mb-3">Create Exam</h3>
                <form method="post">
                    <div class="mb-3">
                        <label for="title" class="form-label">Exam Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" name="add_exam" class="btn btn-primary">Create Exam</button>
                </form>

                <hr class="my-5">

                <h3 class="mb-3">Create School Info</h3>
                <form method="post">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea name="message" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" name="add_school_info" class="btn btn-primary">Create School Info</button>
                </form>

                <hr class="my-5">

                <h3 class="mb-3">Your Exams</h3>
                <ul class="list-group">
                    <?php while ($exam = $exams->fetch_assoc()): ?>
                        <li class="list-group-item">
                            <strong><?php echo $exam['title']; ?></strong><br>
                            <?php echo $exam['description']; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>

                <h3 class="mb-3 mt-5">Your School Info</h3>
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