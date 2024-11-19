<?php
include 'config.php';

if (!isset($_GET['id'])) {
    die("Virheellinen tilan tunnus.");
}

$id = $_GET['id'];

// Haetaan tilan tiedot
$stmt = $conn->prepare("SELECT * FROM Tilat WHERE tunnus = ?");
$stmt->execute([$id]);
$tila = $stmt->fetch();

if (!$tila) {
    die("Tilaa ei löydy.");
}

// Haetaan tilan kurssit ja osallistujamäärä
$stmt = $conn->prepare("SELECT Kurssit.nimi, Kurssit.alkupaiva, Kurssit.loppupaiva, Opettajat.etunimi AS opettaja_etunimi, Opettajat.sukunimi AS opettaja_sukunimi,
                       (SELECT COUNT(*) FROM Kurssikirjautumiset WHERE Kurssikirjautumiset.kurssi_id = Kurssit.tunnus) AS osallistujat
                        FROM Kurssit
                        LEFT JOIN Opettajat ON Kurssit.opettaja_id = Opettajat.tunnusnumero
                        WHERE Kurssit.tila_id = ?");
$stmt->execute([$id]);
$kurssit = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Tilan tiedot</title>
</head>
<body>
    <h1>Tilan tiedot</h1>
    <p>Tunnus: <?php echo htmlspecialchars($tila['tunnus']); ?></p>
    <p>Nimi: <?php echo htmlspecialchars($tila['nimi']); ?></p>
    <p>Kapasiteetti: <?php echo htmlspecialchars($tila['kapasiteetti']); ?></p>

    <h2>Kurssit</h2>
    <table>
        <tr>
            <th>Nimi</th>
            <th>Opettaja</th>
            <th>Aloituspäivämäärä</th>
            <th>Loppupäivämäärä</th>
            <th>Osallistujat</th>
        </tr>
        <?php foreach ($kurssit as $kurssi): 
            $osallistujia = (int)$kurssi['osallistujat'];
            $kapasiteetti = (int)$tila['kapasiteetti'];
            $varoitus = $osallistujia > $kapasiteetti ? "⚠️" : "";
        ?>
            <tr>
                <td><?php echo htmlspecialchars($kurssi['nimi']); ?></td>
                <td><?php echo htmlspecialchars($kurssi['opettaja_etunimi'] . " " . $kurssi['opettaja_sukunimi']); ?></td>
                <td><?php echo htmlspecialchars($kurssi['alkupaiva']); ?></td>
                <td><?php echo htmlspecialchars($kurssi['loppupaiva']); ?></td>
                <td><?php echo $osallistujia . " / " . $kapasiteetti . " " . $varoitus; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
