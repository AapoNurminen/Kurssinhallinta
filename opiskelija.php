<?php
include 'config.php';

if (!isset($_GET['id'])) {
    die("Virheellinen opiskelijanumero.");
}

$id = $_GET['id'];

// Haetaan opiskelijan tiedot
$stmt = $conn->prepare("SELECT * FROM Opiskelijat WHERE opiskelijanumero = ?");
$stmt->execute([$id]);
$opiskelija = $stmt->fetch();

if (!$opiskelija) {
    die("Opiskelijaa ei löydy.");
}

// Haetaan opiskelijan kurssit
$stmt = $conn->prepare("SELECT Kurssit.nimi, Kurssit.alkupaiva FROM Kurssikirjautumiset
                        LEFT JOIN Kurssit ON Kurssikirjautumiset.kurssi_id = Kurssit.tunnus
                        WHERE Kurssikirjautumiset.opiskelija_id = ?");
$stmt->execute([$id]);
$kurssit = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Opiskelijan tiedot</title>
</head>
<body>
    <h1>Opiskelijan tiedot</h1>
    <p>Opiskelijanumero: <?php echo htmlspecialchars($opiskelija['opiskelijanumero']); ?></p>
    <p>Etunimi: <?php echo htmlspecialchars($opiskelija['etunimi']); ?></p>
    <p>Sukunimi: <?php echo htmlspecialchars($opiskelija['sukunimi']); ?></p>
    <p>Vuosikurssi: <?php echo htmlspecialchars($opiskelija['vuosikurssi']); ?></p>

    <h2>Kurssit</h2>
    <table>
        <tr>
            <th>Nimi</th>
            <th>Aloituspäivämäärä</th>
        </tr>
        <?php foreach ($kurssit as $kurssi): ?>
            <tr>
                <td><?php echo htmlspecialchars($kurssi['nimi']); ?></td>
                <td><?php echo htmlspecialchars($kurssi['alkupaiva']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
