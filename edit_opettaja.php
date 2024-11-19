<?php
include 'config.php';

if (isset($_GET['id'])) {
    $tunnusnumero = $_GET['id'];

    // Haetaan opettajan tiedot tietokannasta
    $stmt = $conn->prepare("SELECT * FROM Opettajat WHERE tunnusnumero = :tunnusnumero");
    $stmt->execute(['tunnusnumero' => $tunnusnumero]);
    $opettaja = $stmt->fetch();

    if (!$opettaja) {
        echo "Opettajaa ei löytynyt.";
        exit;
    }
} else {
    echo "Opettajan tunnusnumero puuttuu.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Haetaan lomakkeelta lähetetyt tiedot
    $etunimi = $_POST['etunimi'];
    $sukunimi = $_POST['sukunimi'];
    $aine = $_POST['aine'];

    // Tarkistetaan, onko opettaja jo olemassa samalla nimellä ja aineella
    $stmt = $conn->prepare("SELECT COUNT(*) FROM Opettajat WHERE etunimi = :etunimi AND sukunimi = :sukunimi AND aine = :aine AND tunnusnumero != :tunnusnumero");
    $stmt->execute([
        'etunimi' => $etunimi,
        'sukunimi' => $sukunimi,
        'aine' => $aine,
        'tunnusnumero' => $tunnusnumero
    ]);
    $existingTeacherCount = $stmt->fetchColumn();

    if ($existingTeacherCount > 0) {
        // Jos opettaja on jo olemassa, ilmoitetaan virheestä
        echo "Opettaja, jonka nimi ja aine on samat, löytyy jo tietokannasta!";
    } else {
        // Päivitetään opettajan tiedot tietokannassa
        $updateStmt = $conn->prepare("UPDATE Opettajat SET etunimi = :etunimi, sukunimi = :sukunimi, aine = :aine WHERE tunnusnumero = :tunnusnumero");
        $updateStmt->execute([
            'etunimi' => $etunimi,
            'sukunimi' => $sukunimi,
            'aine' => $aine,
            'tunnusnumero' => $tunnusnumero
        ]);

        // Siirretään takaisin opettajien listaan
        header('Location: opettajat.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Muokkaa Opettajaa</title>
</head>
<body>
    <h1>Muokkaa Opettajaa</h1>
    <form method="POST" action="edit_opettaja.php?id=<?php echo $tunnusnumero; ?>">
        <label for="etunimi">Etunimi:</label>
        <input type="text" id="etunimi" name="etunimi" value="<?php echo htmlspecialchars($opettaja['etunimi']); ?>" required><br><br>

        <label for="sukunimi">Sukunimi:</label>
        <input type="text" id="sukunimi" name="sukunimi" value="<?php echo htmlspecialchars($opettaja['sukunimi']); ?>" required><br><br>

        <label for="aine">Aine:</label>
        <input type="text" id="aine" name="aine" value="<?php echo htmlspecialchars($opettaja['aine']); ?>" required><br><br>

        <input type="submit" value="Päivitä Opettaja">
    </form>
    <br>
    <a href="opettajat.php">Takaisin opettajalistaan</a>
</body>
</html>
