<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

include 'backend/db.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Étudiants</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
<div class="container">
    <h1>📋 Liste des Étudiants</h1>
    <table border="1" cellpadding="10">
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Détails</th>
        </tr>
        <?php
        $stmt = $pdo->query("SELECT * FROM students ORDER BY last_name");
        while ($row = $stmt->fetch()) {
            $id = $row['id'];
            $first = htmlspecialchars($row['first_name']);
            $last = htmlspecialchars($row['last_name']);
            $email = htmlspecialchars($row['email']);
            echo "<tr>";
            echo "<td>$last</td>";
            echo "<td>$first</td>";
            echo "<td>$email</td>";
            echo "<td><a href='student_information.php?id=$id'>Voir détails</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
