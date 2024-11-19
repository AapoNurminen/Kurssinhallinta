<?php
include 'config.php';

if (!isset($_GET['id'])) {
    die("Virheellinen kirjautumistunnus.");
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM Kurssikirjautumiset WHERE tunnus = ?");
$stmt->execute([$id]);

header("Location: kurssikirjautumiset.php");
exit;
?>
