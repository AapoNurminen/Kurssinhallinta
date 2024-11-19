<?php
include 'config.php';

// Haetaan kaikki tilat
$stmt = $conn->query("SELECT * FROM Tilat");
$tilat = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Tilat</title>
</head>
<body>
    <h1>Tilat</h1>
    <table>
        <tr>
            <th>Tunnus</th>
            <th>Nimi</th>
            <th>Kapasiteetti</th>
            <th>Toiminnot</th>
        </tr>
        <?php foreach ($tilat as $tila): ?>
            <tr>
                <td><?php echo htmlspecialchars($tila['tunnus']); ?></td>
                <td><?php echo htmlspecialchars($tila['nimi']); ?></td>
                <td><?php echo htmlspecialchars($tila['kapasiteetti']); ?></td>
                <td>
                    <a href="tila.php?id=<?php echo $tila['tunnus']; ?>">Näytä</a> 
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="index.php">Kotisivulle</a> 
</body>
</html>
