<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?> <!-- Navigation einbinden -->

    <div class="container py-5">
        <div class="card shadow" style="max-width: 400px; margin: 0 auto;">
            <div class="card-header bg-primary text-white">
                <h1 class="card-title">Welcome</h1>
            </div>
            <div class="card-body">
                <p class="lead">Please select your role to log in:</p>
                <ul class="list-unstyled">
                    <li><a href="admin_login.php" class="btn btn-primary w-100 mb-2">Admin Login</a></li>
                    <li><a href="teacher_login.php" class="btn btn-success w-100 mb-2">Teacher Login</a></li>
                    <li><a href="student_login.php" class="btn btn-info w-100 mb-2">Student Login</a></li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>