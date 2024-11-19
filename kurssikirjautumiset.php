<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Kurssikirjautumiset</title>
</head>
<body>
    <h1>Kurssikirjautumiset</h1>
    <table>
        <tr>
            <th>Opiskelija</th>
            <th>Kurssi</th>
            <th>Kirjautumispäivä ja -aika</th>
            <th>Toiminnot</th>
        </tr>
        <?php
        $stmt = $conn->prepare("SELECT Kurssikirjautumiset.tunnus, Kurssikirjautumiset.kirjautumispaiva, Opiskelijat.etunimi AS opiskelija_etunimi, Opiskelijat.sukunimi AS opiskelija_sukunimi, Kurssit.nimi AS kurssi_nimi
                                FROM Kurssikirjautumiset
                                LEFT JOIN Opiskelijat ON Kurssikirjautumiset.opiskelija_id = Opiskelijat.opiskelijanumero
                                LEFT JOIN Kurssit ON Kurssikirjautumiset.kurssi_id = Kurssit.tunnus");
        $stmt->execute();
        $kirjautumiset = $stmt->fetchAll();

        foreach ($kirjautumiset as $kirjautuminen) {
            echo "<tr>
                    <td>{$kirjautuminen['opiskelija_etunimi']} {$kirjautuminen['opiskelija_sukunimi']}</td>
                    <td>{$kirjautuminen['kurssi_nimi']}</td>
                    <td>{$kirjautuminen['kirjautumispaiva']}</td>
                    <td>
                        <a href='edit_kirjautuminen.php?id={$kirjautuminen['tunnus']}'>Muokkaa</a> |
                        <a href='delete_kirjautuminen.php?id={$kirjautuminen['tunnus']}' onclick=\"return confirm('Oletko varma, että haluat poistaa tämän kirjautumisen?');\">Poista</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>
    <a href="add_kirjautuminen.php">Lisää uusi kurssikirjautuminen</a>
    <br>
    <a href="index.php">Kotisivulle</a> 
</body>
</html>
