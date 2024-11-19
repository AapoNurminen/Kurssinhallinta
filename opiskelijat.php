<?php
include 'config.php';

// Haetaan kaikki opiskelijat
$stmt = $conn->query("SELECT * FROM Opiskelijat");
$opiskelijat = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Opiskelijat</title>
</head>
<body>
    <h1>Opiskelijat</h1>
    <table>
        <tr>
            <th>Opiskelijanumero</th>
            <th>Etunimi</th>
            <th>Sukunimi</th>
            <th>Vuosikurssi</th>
            <th>Toiminnot</th>
        </tr>
        <?php foreach ($opiskelijat as $opiskelija): ?>
            <tr>
                <td><?php echo htmlspecialchars($opiskelija['opiskelijanumero']); ?></td>
                <td><?php echo htmlspecialchars($opiskelija['etunimi']); ?></td>
                <td><?php echo htmlspecialchars($opiskelija['sukunimi']); ?></td>
                <td><?php echo htmlspecialchars($opiskelija['vuosikurssi']); ?></td>
                <td>
                    <a href="opiskelija.php?id=<?php echo $opiskelija['opiskelijanumero']; ?>">Näytä</a> |
                    <a href="edit_opiskelija.php?id=<?php echo $opiskelija['opiskelijanumero']; ?>">Muokkaa</a> |
                    <a href="delete_opiskelija.php?id=<?php echo $opiskelija['opiskelijanumero']; ?>" onclick="return confirm('Haluatko varmasti poistaa tämän opiskelijan?');">Poista</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="add_opiskelija.php">Lisää opiskelija</a> 
    <br>
    <a href="index.php">Kotisivulle</a> 
</body>
</html>
