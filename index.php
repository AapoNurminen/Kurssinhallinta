<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Käyttöliittymä - Kurssienhallintajärjestelmä</title>
    <style>
        /* Navigation linkkien väli */
        nav ul li {
            display: inline-block;
            margin-right: 30px; /* Lisää enemmän väliä linkkien väliin */
        }

        nav ul li a {
            padding: 10px 20px; /* Lisää enemmän sisäistä tilaa ympärille */
        }
    </style>
</head>
<body>
    <h1>Kurssienhallinta</h1>
    <nav>
        <ul>
            <li><a href="opiskelijat.php">Opiskelijat</a></li>
            <li><a href="opettajat.php">Opettajat</a></li>
            <li><a href="kurssit.php">Kurssit</a></li>
            <li><a href="tilat.php">Tilat</a></li>
            <li><a href="kurssikirjautumiset.php">Kurssikirjautumiset</a></li>
        </ul>
    </nav>
</body>
</html>
