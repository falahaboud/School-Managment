<?php
function htmlanfang() {
    echo '<!DOCTYPE html>
    <html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Course Management System</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="bg-light">';
}

function htmlende() {
    echo '</body></html>';
}

htmlanfang();

try {
    $db = new PDO('mysql:host=localhost;dbname=School;charset=UTF8', 'root', '');
    $sql = 'SELECT course_id, course_name, description FROM course';
    ?>
    <div class="container mt-4">
        <h2 class="mb-3 text-uppercase fw-bold">Course Management System</h2>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th class="fs-4">Titel</th>
                    <th class="fs-4">Text</th>
                    <th class="fs-4">Aktionen</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($db->query($sql) as $zeile) { ?>
                <tr>
                    <td class="fs-5"><?= htmlspecialchars($zeile[1]); ?></td>
                    <td class="fs-5"><?= htmlspecialchars($zeile[2]); ?></td>
                    <td>
                        <a href="edit.php?course_id=<?= $zeile[0]; ?>" class="btn btn-primary btn-lg">Edit</a>
                        <a href="delete.php?course_id=<?= $zeile[0]; ?>" class="btn btn-dark btn-lg" onclick="return confirm('Do you want Delete it?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <a href="new.php" class="btn btn-success btn-lg">Add New Course</a>
    </div>
    <?php
} catch (PDOException $e) {
    echo '<div class="alert alert-danger">Sorry this not Good ' . htmlspecialchars($e->getMessage()) . '</div>';
}
htmlende();
