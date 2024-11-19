<?php
include 'config.php';

if (isset($_GET['id'])) {
    $opiskelijanumero = $_GET['id'];

    // Poistetaan kaikki kurssikirjautumiset, joissa opiskelija on mukana
    $stmt = $conn->prepare("DELETE FROM Kurssikirjautumiset WHERE opiskelija_id = ?");
    $stmt->execute([$opiskelijanumero]);

    // Poistetaan opiskelija
    $stmt = $conn->prepare("DELETE FROM Opiskelijat WHERE opiskelijanumero = ?");
    $stmt->execute([$opiskelijanumero]);

    echo "Opiskelija poistettu!";
    header("Location: opiskelijat.php");
    exit;
} else {
    echo "Opiskelijaa ei löydetty.";
}
?>
 <br>
 <a href="opiskelijat.php">Takasin</a> 
