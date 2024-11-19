<?php
include 'config.php';

if (!isset($_GET['id'])) {
    die("Virheellinen kirjautumistunnus.");
}

$id = $_GET['id'];

// Haetaan nykyinen kirjautumistieto
$stmt = $conn->prepare("SELECT * FROM Kurssikirjautumiset WHERE tunnus = ?");
$stmt->execute([$id]);
$kirjautuminen = $stmt->fetch();

if (!$kirjautuminen) {
    die("Kurssikirjautumista ei löydy.");
}

if (isset($_POST['submit'])) {
    $opiskelija_id = $_POST['opiskelija_id'];
    $kurssi_id = $_POST['kurssi_id'];

    // Tarkistetaan, onko opiskelija jo ilmoittautunut tälle kurssille
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM Kurssikirjautumiset WHERE opiskelija_id = ? AND kurssi_id = ?");
    $checkStmt->execute([$opiskelija_id, $kurssi_id]);
    $existingEnrollment = $checkStmt->fetchColumn();

    if ($existingEnrollment > 0) {
        // Jos opiskelija on jo ilmoittautunut kurssille, näytetään virheilmoitus
        echo "Tämä opiskelija on jo ilmoittautunut tälle kurssille!";
    } else {
        // Jos ei ole, päivitetään kirjautuminen
        $stmt = $conn->prepare("UPDATE Kurssikirjautumiset SET opiskelija_id = ?, kurssi_id = ? WHERE tunnus = ?");
        $stmt->execute([$opiskelija_id, $kurssi_id, $id]);
        header("Location: kurssikirjautumiset.php"); // Adjust the URL to the page you want to redirect to
        exit(); 
       // echo "Kurssikirjautuminen päivitetty!";
    }
}

?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Muokkaa kurssikirjautumista</title>
</head>
<body>
    <h1>Muokkaa kurssikirjautumista</h1>
    <form method="post" action="">
        <label>Opiskelija:</label>
        <select name="opiskelija_id" required>
            <?php
            $stmt = $conn->prepare("SELECT * FROM Opiskelijat");
            $stmt->execute();
            $opiskelijat = $stmt->fetchAll();
            foreach ($opiskelijat as $opiskelija) {
                $selected = $opiskelija['opiskelijanumero'] == $kirjautuminen['opiskelija_id'] ? "selected" : "";
                echo "<option value='{$opiskelija['opiskelijanumero']}' $selected>{$opiskelija['etunimi']} {$opiskelija['sukunimi']}</option>";
            }
            ?>
        </select><br>

        <label>Kurssi:</label>
        <select name="kurssi_id" required>
            <?php
            $stmt = $conn->prepare("SELECT * FROM Kurssit");
            $stmt->execute();
            $kurssit = $stmt->fetchAll();
            foreach ($kurssit as $kurssi) {
                $selected = $kurssi['tunnus'] == $kirjautuminen['kurssi_id'] ? "selected" : "";
                echo "<option value='{$kurssi['tunnus']}' $selected>{$kurssi['nimi']}</option>";
            }
            ?>
        </select><br>

        <input type="submit" name="submit" value="Tallenna muutokset">
    </form>
    <br>
      <a href="kurssikirjautumiset.php">Takaisin</a> 
</body>
</html>
