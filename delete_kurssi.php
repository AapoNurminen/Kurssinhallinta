<?php
include 'config.php';

if (isset($_GET['id'])) {
    $kurssi_id = $_GET['id'];

    // Poistetaan kaikki kurssikirjautumiset, joissa kurssi on mukana
    $stmt = $conn->prepare("DELETE FROM Kurssikirjautumiset WHERE kurssi_id = ?");
    $stmt->execute([$kurssi_id]);

    // Poistetaan kurssi
    $stmt = $conn->prepare("DELETE FROM Kurssit WHERE tunnus = ?");
    $stmt->execute([$kurssi_id]);

    header('Location: kurssit.php');
    exit;
} else {
    echo "Kurssin tunnus puuttuu.";
    exit;
}
?>
