<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit();
}
include 'db.php';

// Add Teacher
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_teacher'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO teachers (first_name, last_name, username, password) VALUES ('$first_name', '$last_name', '$username', '$password')";
    $conn->query($sql);
}

// Add Student
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_student'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $teacher_id = $_POST['teacher_id'];

    $sql = "INSERT INTO students (first_name, last_name, username, password, teacher_id) VALUES ('$first_name', '$last_name', '$username', '$password', '$teacher_id')";
    $conn->query($sql);
}

// Delete Teacher
if (isset($_GET['delete_teacher'])) {
    $teacher_id = $_GET['delete_teacher'];
    $sql = "DELETE FROM teachers WHERE id='$teacher_id'";
    $conn->query($sql);
    header('Location: admin_dashboard.php');
}

// Delete Student
if (isset($_GET['delete_student'])) {
    $student_id = $_GET['delete_student'];
    $sql = "DELETE FROM students WHERE id='$student_id'";
    $conn->query($sql);
    header('Location: admin_dashboard.php');
}

// Get all teachers for the dropdown
$teachers = $conn->query("SELECT id, first_name, last_name FROM teachers");

// Get all teachers and students for display
$all_teachers = $conn->query("SELECT * FROM teachers");
$all_students = $conn->query("SELECT students.*, teachers.first_name AS teacher_first_name, teachers.last_name AS teacher_last_name FROM students LEFT JOIN teachers ON students.teacher_id = teachers.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?> <!-- Navigation einbinden -->

    <div class="container py-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h1 class="card-title">Admin Dashboard</h1>
            </div>
            <div class="card-body">
                <h2 class="mb-4">Add Teacher</h2>
                <form method="post" class="mb-5">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" name="add_teacher" class="btn btn-primary">Add Teacher</button>
                </form>

                <h2 class="mb-4">Add Student</h2>
                <form method="post">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="teacher_id" class="form-label">Teacher</label>
                        <select name="teacher_id" class="form-select" required>
                            <?php while ($teacher = $teachers->fetch_assoc()): ?>
                                <option value="<?php echo $teacher['id']; ?>">
                                    <?php echo $teacher['first_name'] . ' ' . $teacher['last_name']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" name="add_student" class="btn btn-primary">Add Student</button>
                </form>

                <hr class="my-5">

                <h2 class="mb-4">Teachers List</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($teacher = $all_teachers->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $teacher['id']; ?></td>
                                <td><?php echo $teacher['first_name']; ?></td>
                                <td><?php echo $teacher['last_name']; ?></td>
                                <td><?php echo $teacher['username']; ?></td>
                                <td>
                                    <a href="edit_teacher.php?id=<?php echo $teacher['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="admin_dashboard.php?delete_teacher=<?php echo $teacher['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this teacher?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <h2 class="mb-4">Students List</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                            <th>Assigned Teacher</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($student = $all_students->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $student['id']; ?></td>
                                <td><?php echo $student['first_name']; ?></td>
                                <td><?php echo $student['last_name']; ?></td>
                                <td><?php echo $student['username']; ?></td>
                                <td>
                                    <?php
                                    if ($student['teacher_first_name']) {
                                        echo $student['teacher_first_name'] . ' ' . $student['teacher_last_name'];
                                    } else {
                                        echo 'Not Assigned';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="edit_student.php?id=<?php echo $student['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="admin_dashboard.php?delete_student=<?php echo $student['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-end">
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>