<?php
include 'config.php';

if (isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM Opiskelijat WHERE opiskelijanumero = ?");
    $stmt->execute([$_GET['id']]);
    $opiskelija = $stmt->fetch();

    if (!$opiskelija) {
        echo "Opiskelijaa ei löytynyt.";
        exit;
    }
}

if (isset($_POST['submit'])) {
    $etunimi = $_POST['etunimi'];
    $sukunimi = $_POST['sukunimi'];
    $syntymapaiva = $_POST['syntymapaiva'];
    $vuosikurssi = $_POST['vuosikurssi'];
    $id = $_POST['id'];

    // Tarkistetaan, onko opiskelija jo olemassa samalla nimellä
    $stmt = $conn->prepare("SELECT COUNT(*) FROM Opiskelijat WHERE etunimi = :etunimi AND sukunimi = :sukunimi AND opiskelijanumero != :id");
    $stmt->execute([
        'etunimi' => $etunimi,
        'sukunimi' => $sukunimi,
        'id' => $id
    ]);
    $existingStudentCount = $stmt->fetchColumn();

    if ($existingStudentCount > 0) {
        // Jos opiskelija on jo olemassa, ilmoitetaan virheestä
        echo "Opiskelija, jonka nimi on sama, löytyy jo tietokannasta!";
    } else {
        // Päivitetään opiskelijan tiedot tietokannassa
        $stmt = $conn->prepare("UPDATE Opiskelijat SET etunimi = ?, sukunimi = ?, syntymapaiva = ?, vuosikurssi = ? WHERE opiskelijanumero = ?");
        $stmt->execute([$etunimi, $sukunimi, $syntymapaiva, $vuosikurssi, $id]);
        echo "Opiskelijan tiedot päivitetty!";
        header("Location: opiskelijat.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Muokkaa opiskelijaa</title>
</head>
<body>
    <h1>Muokkaa opiskelijaa</h1>
    <form method="post" action="">
        <input type="hidden" name="id" value="<?= $opiskelija['opiskelijanumero'] ?>">
        <label>Etunimi:</label><input type="text" name="etunimi" value="<?= htmlspecialchars($opiskelija['etunimi']) ?>" required><br>
        <label>Sukunimi:</label><input type="text" name="sukunimi" value="<?= htmlspecialchars($opiskelija['sukunimi']) ?>" required><br>
        <label>Syntymäpäivä:</label><input type="date" name="syntymapaiva" value="<?= $opiskelija['syntymapaiva'] ?>" required><br>
        <label>Vuosikurssi:</label><input type="number" name="vuosikurssi" value="<?= $opiskelija['vuosikurssi'] ?>" min="1" max="3" required><br>
        <input type="submit" name="submit" value="Päivitä">
    </form>
</body>
<br>
<a href="opiskelijat.php">Takaisin</a> 
</html>
