<?php
require_once 'htmlhelfer.php';
$host = htmlspecialchars($_SERVER['HTTP_HOST']);
$uri = rtrim(dirname(htmlspecialchars($_SERVER['PHP_SELF'])), "/\\");
$extra = 'show.php';

if (empty($_POST['titel']) || empty($_POST['text'])) {
    htmlanfang();
?>
    <!DOCTYPE html>
    <html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Course Add</title>
        <!-- Bootstrap CSS-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-5">
            <h2 class="mb-4">Course Add</h2>
            <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="mb-3">
                    <label for="titel" class="form-label">Course Name</label>
                    <input type="text" class="form-control" name="titel" id="titel" maxlength="25">
                </div>
                <div class="mb-3">
                    <label for="text" class="form-label">Text</label>
                    <textarea class="form-control" name="text" id="text" rows="5" cols="30"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>

        <!-- Bootstrap JS und Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    </body>
    </html>
<?php
    htmlende();
} else {
    try {
        $db = new PDO('mysql:host=localhost;dbname=School;charset=UTF8', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

      
        $titel = $_POST['titel'];
        $text = $_POST['text'];

        if (empty($titel) || empty($text)) {
            throw new Exception("Both fields must be filled!");
        }

        $sql = 'INSERT INTO course (course_name, description) VALUES (?, ?)';
        $stmt = $db->prepare($sql);
        $stmt->execute([$titel, $text]);

    
        header("Location: http://$host$uri/$extra");
        exit();
    } catch (PDOException $e) {
        echo 'Database error: ' . $e->getMessage();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
