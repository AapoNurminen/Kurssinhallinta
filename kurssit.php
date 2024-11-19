<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Kurssit</title>
    <style>
        .over-capacity {
           // background-color: red; /* Red for over capacity */
            color: red;
        }
        .close-to-capacity {
            color: yellow; /* Yellow for close to capacity */
        }
    </style>
</head>
<body>
    <h1>Kurssit</h1>
    <table>
        <tr>
            <th>Tunnus</th>
            <th>Nimi</th>
            <th>Kuvaus</th>
            <th>Alkupäivä</th>
            <th>Loppupäivä</th>
            <th>Opettaja</th>
            <th>Tila</th>
            <th>Kapasiteetti</th>
            <th>Opiskelijat</th>
            <th>Toiminnot</th>
        </tr>
        <?php
        // Haetaan kaikki kurssit, sisältäen kapasiteetti tiedon
        $stmt = $conn->prepare("SELECT Kurssit.*, Opettajat.etunimi AS opettaja_etunimi, Opettajat.sukunimi AS opettaja_sukunimi, Tilat.nimi AS tila_nimi, Tilat.kapasiteetti
                                FROM Kurssit
                                LEFT JOIN Opettajat ON Kurssit.opettaja_id = Opettajat.tunnusnumero
                                LEFT JOIN Tilat ON Kurssit.tila_id = Tilat.tunnus");
        $stmt->execute();
        $kurssit = $stmt->fetchAll();

        // Käydään läpi kaikki kurssit
        foreach ($kurssit as $kurssi) {
            // Haetaan opiskelijat, jotka ovat ilmoittautuneet tälle kurssille
            $opiskelijatStmt = $conn->prepare("SELECT Opiskelijat.etunimi, Opiskelijat.sukunimi, Opiskelijat.vuosikurssi 
                                              FROM Opiskelijat 
                                              JOIN kurssikirjautumiset ON Opiskelijat.opiskelijanumero = kurssikirjautumiset.opiskelija_id
                                              WHERE kurssikirjautumiset.kurssi_id = :kurssi_id");
            $opiskelijatStmt->execute(['kurssi_id' => $kurssi['tunnus']]);
            $opiskelijat = $opiskelijatStmt->fetchAll();

            // Luodaan lista opiskelijoista
            $opiskelijalista = '';
            foreach ($opiskelijat as $opiskelija) {
                $opiskelijalista .= htmlspecialchars($opiskelija['etunimi']) . ' ' . htmlspecialchars($opiskelija['sukunimi']) . ' (Vuosikurssi: ' . htmlspecialchars($opiskelija['vuosikurssi']) . ')<br>';
            }

            // Tarkistetaan, onko opiskelijoiden määrä ylittänyt kapasiteetin
            $opiskelijoidenLkm = count($opiskelijat);
            $capacityStatusClass = '';
            if ($opiskelijoidenLkm > $kurssi['kapasiteetti']) {
                $capacityStatusClass = 'over-capacity'; // punainen tausta
            } elseif ($opiskelijoidenLkm >= 0.8 * $kurssi['kapasiteetti']) {
                $capacityStatusClass = 'close-to-capacity'; // keltainen tausta
            }

            // Näytetään kurssin tiedot ja opiskelijalista
            echo "<tr>
                    <td>{$kurssi['tunnus']}</td>
                    <td>{$kurssi['nimi']}</td>
                    <td>{$kurssi['kuvaus']}</td>
                    <td>{$kurssi['alkupaiva']}</td>
                    <td>{$kurssi['loppupaiva']}</td>
                    <td>{$kurssi['opettaja_etunimi']} {$kurssi['opettaja_sukunimi']}</td>
                    <td>{$kurssi['tila_nimi']}</td>
                    <td class='{$capacityStatusClass}'>$opiskelijoidenLkm / {$kurssi['kapasiteetti']}</td>
                    <td>{$opiskelijalista}</td>
                    <td>
                        <a href='edit_kurssi.php?id={$kurssi['tunnus']}'>Muokkaa</a>
                        <a href='delete_kurssi.php?id={$kurssi['tunnus']}'>Poista</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>
    <a href="add_kurssi.php">Lisää kurssi</a>
    <br>
    <a href="index.php">Kotisivulle</a> 
</body>
</html>
