<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Lisää opiskelija</title>
</head>
<body>
    <h1>Lisää opiskelija</h1>
    <form method="post" action="add_opiskelija.php">
        <label>Etunimi:</label><input type="text" name="etunimi" required><br>
        <label>Sukunimi:</label><input type="text" name="sukunimi" required><br>
        <label>Syntymäpäivä:</label><input type="date" name="syntymapaiva" required><br>
        <label>Vuosikurssi:</label><input type="number" name="vuosikurssi" min="1" max="3" required><br>
        <input type="submit" name="submit" value="Tallenna">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $etunimi = $_POST['etunimi'];
        $sukunimi = $_POST['sukunimi'];
        $syntymapaiva = $_POST['syntymapaiva'];
        $vuosikurssi = $_POST['vuosikurssi'];

        // Tarkistetaan, onko opiskelija jo olemassa samalla nimellä
        $stmt = $conn->prepare("SELECT COUNT(*) FROM Opiskelijat WHERE etunimi = :etunimi AND sukunimi = :sukunimi");
        $stmt->execute([
            'etunimi' => $etunimi,
            'sukunimi' => $sukunimi
        ]);
        $existingStudentCount = $stmt->fetchColumn();

        if ($existingStudentCount > 0) {
            // Jos opiskelija on jo olemassa, ilmoitetaan virheestä
            echo "Opiskelija, jonka nimi on sama, löytyy jo tietokannasta!";
        } else {
            // Lisätään opiskelija tietokantaan
            $stmt = $conn->prepare("INSERT INTO Opiskelijat (etunimi, sukunimi, syntymapaiva, vuosikurssi) VALUES (?, ?, ?, ?)");
            $stmt->execute([$etunimi, $sukunimi, $syntymapaiva, $vuosikurssi]);
            echo "Opiskelija lisätty onnistuneesti!";
        }
    }
    ?>
    <br>
    <a href="opiskelijat.php">Takaisin opiskelijalistaan</a> 
</body>
</html>
