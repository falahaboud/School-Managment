<?php

$host = htmlspecialchars($_SERVER['HTTP_HOST']);
$uri = rtrim(dirname(htmlspecialchars($_SERVER['PHP_SELF'])), "/\\");
$extra = 'show.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: http://$host$uri/$extra");
}


try {
    $id = $_GET['course_id'];
    $db = new PDO('mysql:host=localhost;dbname=School;charset=utf8mb4', 'root', '');
    $sql = 'DELETE FROM course WHERE course_id=?';
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    header("Location: http://$host$uri/$extra");
} catch (PDOException $e) {
    echo 'Sorry this not Ok: ' . $e->getMessage();
}
