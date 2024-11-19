<?php
include 'config.php';

if (!isset($_GET['id'])) {
    die("Virheellinen opettajatunnus.");
}

$id = $_GET['id'];

// Haetaan opettajan tiedot
$stmt = $conn->prepare("SELECT * FROM Opettajat WHERE tunnusnumero = ?");
$stmt->execute([$id]);
$opettaja = $stmt->fetch();

if (!$opettaja) {
    die("Opettajaa ei löydy.");
}

// Haetaan opettajan kurssit
$stmt = $conn->prepare("SELECT Kurssit.nimi, Kurssit.alkupaiva, Kurssit.loppupaiva, Tilat.nimi AS tila_nimi 
                        FROM Kurssit
                        LEFT JOIN Tilat ON Kurssit.tila_id = Tilat.tunnus
                        WHERE Kurssit.opettaja_id = ?");
$stmt->execute([$id]);
$kurssit = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Opettajan tiedot</title>
</head>
<body>
    <h1>Opettajan tiedot</h1>
    <p>Tunnusnumero: <?php echo htmlspecialchars($opettaja['tunnusnumero']); ?></p>
    <p>Etunimi: <?php echo htmlspecialchars($opettaja['etunimi']); ?></p>
    <p>Sukunimi: <?php echo htmlspecialchars($opettaja['sukunimi']); ?></p>
    <p>Aine: <?php echo htmlspecialchars($opettaja['aine']); ?></p>

    <h2>Kurssit</h2>
    <table>
        <tr>
            <th>Nimi</th>
            <th>Aloituspäivämäärä</th>
            <th>Loppupäivämäärä</th>
            <th>Tila</th>
        </tr>
        <?php foreach ($kurssit as $kurssi): ?>
            <tr>
                <td><?php echo htmlspecialchars($kurssi['nimi']); ?></td>
                <td><?php echo htmlspecialchars($kurssi['alkupaiva']); ?></td>
                <td><?php echo htmlspecialchars($kurssi['loppupaiva']); ?></td>
                <td><?php echo htmlspecialchars($kurssi['tila_nimi']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
