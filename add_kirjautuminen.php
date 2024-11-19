<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Lisää kurssikirjautuminen</title>
</head>
<body>
    <h1>Lisää kurssikirjautuminen</h1>
    <form method="post" action="">
        <label>Opiskelija:</label>
        <select name="opiskelija_id" required>
            <?php
            $stmt = $conn->prepare("SELECT * FROM Opiskelijat");
            $stmt->execute();
            $opiskelijat = $stmt->fetchAll();
            foreach ($opiskelijat as $opiskelija) {
                echo "<option value='{$opiskelija['opiskelijanumero']}'>{$opiskelija['etunimi']} {$opiskelija['sukunimi']}</option>";
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
                echo "<option value='{$kurssi['tunnus']}'>{$kurssi['nimi']}</option>";
            }
            ?>
        </select><br>

        <input type="submit" name="submit" value="Tallenna">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $opiskelija_id = $_POST['opiskelija_id'];
        $kurssi_id = $_POST['kurssi_id'];

        // Check if the student is already enrolled in the selected course
        $checkStmt = $conn->prepare("SELECT COUNT(*) FROM Kurssikirjautumiset WHERE opiskelija_id = ? AND kurssi_id = ?");
        $checkStmt->execute([$opiskelija_id, $kurssi_id]);
        $existingEnrollment = $checkStmt->fetchColumn();

        if ($existingEnrollment > 0) {
            // If the student is already enrolled in this course, display a message
            echo "Tämä opiskelija on jo ilmoittautunut tälle kurssille!";
        } else {
            // If not, insert the enrollment
            $stmt = $conn->prepare("INSERT INTO Kurssikirjautumiset (opiskelija_id, kurssi_id, kirjautumispaiva) VALUES (?, ?, NOW())");
            $stmt->execute([$opiskelija_id, $kurssi_id]);
            echo "Kurssikirjautuminen lisätty onnistuneesti!";
        }
    }
    ?>
      <br>
      <a href="kurssikirjautumiset.php">Takaisin</a> 
</body>
</html>
