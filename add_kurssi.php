<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nimi = $_POST['nimi'];
    $kuvaus = $_POST['kuvaus'];
    $alkupaiva = $_POST['alkupaiva'];
    $loppupaiva = $_POST['loppupaiva'];
    $opettaja_id = $_POST['opettaja_id'];
    $tila_id = $_POST['tila_id'];

    // Lisätään uusi kurssi tietokantaan
    $stmt = $conn->prepare("INSERT INTO Kurssit (nimi, kuvaus, alkupaiva, loppupaiva, opettaja_id, tila_id) 
                            VALUES (:nimi, :kuvaus, :alkupaiva, :loppupaiva, :opettaja_id, :tila_id)");
    $stmt->execute([
        'nimi' => $nimi,
        'kuvaus' => $kuvaus,
        'alkupaiva' => $alkupaiva,
        'loppupaiva' => $loppupaiva,
        'opettaja_id' => $opettaja_id,
        'tila_id' => $tila_id
    ]);

    header('Location: kurssit.php');
    exit;
}

$opettajatStmt = $conn->prepare("SELECT * FROM Opettajat");
$opettajatStmt->execute();
$opettajat = $opettajatStmt->fetchAll();

$tilatStmt = $conn->prepare("SELECT * FROM Tilat");
$tilatStmt->execute();
$tilat = $tilatStmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Lisää Kurssi</title>
</head>
<body>
    <h1>Lisää uusi kurssi</h1>
    <form method="POST">
        <label for="nimi">Kurssin nimi:</label>
        <input type="text" id="nimi" name="nimi" required><br><br>

        <label for="kuvaus">Kurssin kuvaus:</label>
        <textarea id="kuvaus" name="kuvaus" required></textarea><br><br>

        <label for="alkupaiva">Alkupäivämäärä:</label>
        <input type="date" id="alkupaiva" name="alkupaiva" required><br><br>

        <label for="loppupaiva">Loppupäivämäärä:</label>
        <input type="date" id="loppupaiva" name="loppupaiva" required><br><br>

        <label for="opettaja_id">Opettaja:</label>
        <select id="opettaja_id" name="opettaja_id" required>
            <?php foreach ($opettajat as $opettaja): ?>
                <option value="<?= $opettaja['tunnusnumero'] ?>"><?= $opettaja['etunimi'] ?> <?= $opettaja['sukunimi'] ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="tila_id">Tila:</label>
        <select id="tila_id" name="tila_id" required>
            <?php foreach ($tilat as $tila): ?>
                <option value="<?= $tila['tunnus'] ?>"><?= $tila['nimi'] ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <input type="submit" value="Lisää kurssi">
    </form>
    <br>
    <a href="kurssit.php">Takaisin kurssilistaus</a>
</body>
</html>
