<?php
require_once 'htmlhelfer.php';
$host = htmlspecialchars($_SERVER['HTTP_HOST']);
$uri = rtrim(dirname(htmlspecialchars($_SERVER['PHP_SELF'])), "/\\");
$extra = 'show.php';

try {
    $db = new PDO('mysql:host=localhost;dbname=School;charset=UTF8', 'root', '');
} catch (PDOException $e) {
    die('<div class="alert alert-danger">Sorry this is not good ' . htmlspecialchars($e->getMessage()) . '</div>');
}

if (empty($_POST['titel'])) {
    // Just comment
    if (!isset($_GET['course_id']) || !is_numeric($_GET['course_id'])) {
        header("Location: http://$host$uri/$extra");
    }
    htmlanfang();

    // Course Date from database
    $id = $_GET['course_id'];
    $sql = 'SELECT course_id, course_name, description FROM course WHERE course_id=?';
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $zeile = $stmt->fetch(PDO::FETCH_ASSOC);
    $titel = htmlspecialchars($zeile['course_name']);
    $text = htmlspecialchars($zeile['description']);
    ?>
    <div class="container mt-4">
        <h2 class="mb-3 text-uppercase fw-bold">Course Edit</h2>
        <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="bg-white p-4 rounded shadow">
            <div class="mb-3">
                <label for="titel" class="form-label fw-bold">Course Name</label>
                <input type="text" name="titel" id="titel" class="form-control" maxlength="25" value="<?= $titel; ?>" required>
            </div>
            <div class="mb-3">
                <label for="text" class="form-label fw-bold">Description</label>
                <textarea name="text" id="text" class="form-control" rows="5" required><?= $text; ?></textarea>
            </div>
            <input type="hidden" name="id" value="<?= $id; ?>"> <!-- Versteckte ID -->
            <button type="submit" class="btn btn-primary btn-lg">Update</button>
            <a href="show.php" class="btn btn-secondary btn-lg">Cancel</a>
        </form>
    </div>
    <?php
    htmlende();
} else {
    // POST-Daten abrufen
    $id = $_POST['id'];  // ID aus dem versteckten Feld
    $titel = $_POST['titel'];  // Titel aus dem Formular
    $text = $_POST['text'];  // Text aus dem Formular

    // SQL-Abfrage zum Aktualisieren
    $sql = 'UPDATE course SET course_name=?, description=? WHERE course_id=?';
    $stmt = $db->prepare($sql);
    $stmt->execute([$titel, $text, $id]);

    // Weiterleitung nach erfolgreichem Update
    header("Location: http://$host$uri/$extra");
    exit();  // Sicherstellen, dass keine weitere Ausführung erfolgt
}
?>
