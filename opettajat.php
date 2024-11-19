<?php
include 'config.php';

// Haetaan kaikki opettajat
$stmt = $conn->query("SELECT * FROM Opettajat");
$opettajat = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Opettajat</title>
</head>
<body>
    <h1>Opettajat</h1>
    <table>
        <tr>
            <th>Tunnusnumero</th>
            <th>Etunimi</th>
            <th>Sukunimi</th>
            <th>Aine</th>
            <th>Toiminnot</th>
        </tr>
        <?php foreach ($opettajat as $opettaja): ?>
            <tr>
                <td><?php echo htmlspecialchars($opettaja['tunnusnumero']); ?></td>
                <td><?php echo htmlspecialchars($opettaja['etunimi']); ?></td>
                <td><?php echo htmlspecialchars($opettaja['sukunimi']); ?></td>
                <td><?php echo htmlspecialchars($opettaja['aine']); ?></td>
                <td>
                    <a href="opettaja.php?id=<?php echo $opettaja['tunnusnumero']; ?>">Näytä</a> |
                    <a href="edit_opettaja.php?id=<?php echo $opettaja['tunnusnumero']; ?>">Muokkaa</a> |
                    <a href="delete_opettaja.php?id=<?php echo $opettaja['tunnusnumero']; ?>" onclick="return confirm('Haluatko varmasti poistaa tämän opettajan?');">Poista</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="add_opettaja.php">Lisää opettaja</a> 
    <br>
    <a href="index.php">Kotisivulle</a> 
</body>
</html>
