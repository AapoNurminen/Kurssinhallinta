<?php

echo '<link rel="stylesheet" href="style.css">';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Oppilaitos";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8mb4'");
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
