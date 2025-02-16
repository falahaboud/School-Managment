<?php
$password = 'password'; // Ihr Passwort
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo "Generated Hash: " . $hashed_password; // Kopieren Sie diesen Hash in die Datenbank
?>