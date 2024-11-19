<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Lisää opettaja</title>
</head>
<body>
    <h1>Lisää opettaja</h1>
    <form method="post" action="">
        <label>Etunimi:</label><input type="text" name="etunimi" required><br>
        <label>Sukunimi:</label><input type="text" name="sukunimi" required><br>
        <label>Aine:</label><input type="text" name="aine" required><br>
        <input type="submit" name="submit" value="Tallenna">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $etunimi = $_POST['etunimi'];
        $sukunimi = $_POST['sukunimi'];
        $aine = $_POST['aine'];

        // Check if a teacher with the same first name and last name already exists
        $stmt = $conn->prepare("SELECT COUNT(*) FROM Opettajat WHERE etunimi = ? AND sukunimi = ?");
        $stmt->execute([$etunimi, $sukunimi]);
        $existingTeacherCount = $stmt->fetchColumn();

        if ($existingTeacherCount > 0) {
            // If a teacher with the same name exists, show an error message
            echo "Opettaja, jonka nimi on $etunimi $sukunimi, on jo olemassa!";
        } else {
            // If no teacher exists with the same name, insert the new teacher
            $stmt = $conn->prepare("INSERT INTO Opettajat (etunimi, sukunimi, aine) VALUES (?, ?, ?)");
            $stmt->execute([$etunimi, $sukunimi, $aine]);
            echo "Opettaja lisätty onnistuneesti!";
        }
    }
    ?>
    <br>
    <a href="opettajat.php">Takaisin</a>
</body>
</html>
