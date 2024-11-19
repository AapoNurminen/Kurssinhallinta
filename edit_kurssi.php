<?php
include 'config.php';

if (isset($_GET['id'])) {
    $tunnus = $_GET['id'];

    // Haetaan kurssin tiedot tietokannasta
    $stmt = $conn->prepare("SELECT * FROM Kurssit WHERE tunnus = :tunnus");
    $stmt->execute(['tunnus' => $tunnus]);
    $kurssi = $stmt->fetch();

    if (!$kurssi) {
        echo "Kurssia ei löytynyt.";
        exit;
    }
} else {
    echo "Kurssin tunnus puuttuu.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nimi = $_POST['nimi'];
    $kuvaus = $_POST['kuvaus'];
    $alkupaiva = $_POST['alkupaiva'];
    $loppupaiva = $_POST['loppupaiva'];
    $opettaja_id = $_POST['opettaja_id'];
    $tila_id = $_POST['tila_id'];

    // Päivitetään kurssin tiedot
    $updateStmt = $conn->prepare("UPDATE Kurssit SET nimi = :nimi, kuvaus = :kuvaus, alkupaiva = :alkupaiva, loppupaiva = :loppupaiva, opettaja_id = :opettaja_id, tila_id = :tila_id WHERE tunnus = :tunnus");
    $updateStmt->execute([
        'nimi' => $nimi,
        'kuvaus' => $kuvaus,
        'alkupaiva' => $alkupaiva,
        'loppupaiva' => $loppupaiva,
        'opettaja_id' => $opettaja_id,
        'tila_id' => $tila_id,
        'tunnus' => $tunnus
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
    <title>Muokkaa Kurssia</title>
</head>
<body>
    <h1>Muokkaa kurssia: <?= htmlspecialchars($kurssi['nimi']) ?></h1>
    <form method="POST">
        <label for="nimi">Kurssin nimi:</label>
        <input type="text" id="nimi" name="nimi" value="<?= htmlspecialchars($kurssi['nimi']) ?>" required><br><br>

        <label for="kuvaus">Kurssin kuvaus:</label>
        <textarea id="kuvaus" name="kuvaus" required><?= htmlspecialchars($kurssi['kuvaus']) ?></textarea><br><br>

        <label for="alkupaiva">Alkupäivämäärä:</label>
        <input type="date" id="alkupaiva" name="alkupaiva" value="<?= htmlspecialchars($kurssi['alkupaiva']) ?>" required><br><br>

        <label for="loppupaiva">Loppupäivämäärä:</label>
        <input type="date" id="loppupaiva" name="loppupaiva" value="<?= htmlspecialchars($kurssi['loppupaiva']) ?>" required><br><br>

        <label for="opettaja_id">Opettaja:</label>
        <select id="opettaja_id" name="opettaja_id" required>
            <?php foreach ($opettajat as $opettaja): ?>
                <option value="<?= $opettaja['tunnusnumero'] ?>" <?= $opettaja['tunnusnumero'] == $kurssi['opettaja_id'] ? 'selected' : '' ?>>
                    <?= $opettaja['etunimi'] ?> <?= $opettaja['sukunimi'] ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="tila_id">Tila:</label>
        <select id="tila_id" name="tila_id" required>
            <?php foreach ($tilat as $tila): ?>
                <option value="<?= $tila['tunnus'] ?>" <?= $tila['tunnus'] == $kurssi['tila_id'] ? 'selected' : '' ?>>
                    <?= $tila['nimi'] ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <input type="submit" value="Päivitä kurssi">
    </form>
    <br>
    <a href="kurssit.php">Takaisin kurssilistaus</a>
</body>
</html>
