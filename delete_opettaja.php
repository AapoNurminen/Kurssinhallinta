<?php
include 'config.php';

if (isset($_GET['id'])) {
    $opettaja_tunnusnumero = $_GET['id'];

    // Check if the teacher is assigned to any courses
    $stmt = $conn->prepare("SELECT COUNT(*) FROM Kurssit WHERE opettaja_id = ?");
    $stmt->execute([$opettaja_tunnusnumero]);
    $courseCount = $stmt->fetchColumn();

    if ($courseCount > 0) {
        // There are courses that depend on this teacher, so we won't delete the teacher
        echo "Et voi poistaa opettajaa, koska hänellä on vielä kursseja, joissa hän on vastuussa. Poista opettaja kaikilta kursseilta ennen poistamista.";
    } else {
        // No courses depend on this teacher, so we can delete the teacher
        $stmt = $conn->prepare("DELETE FROM Opettajat WHERE tunnusnumero = ?");
        $stmt->execute([$opettaja_tunnusnumero]);

        echo "Opettaja poistettu onnistuneesti!";
        header('Location: opettajat.php');
        exit;
    }
} else {
    echo "Opettajan tunnusnumero puuttuu.";
    exit;
}
?>
 <br>
 <a href="opettajat.php">Takasin</a> 