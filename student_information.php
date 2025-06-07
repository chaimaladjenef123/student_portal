<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

include 'backend/db.php';

if (!isset($_GET['id'])) {
    echo "ID étudiant manquant.";
    exit;
}

$id = (int) $_GET['id'];

// Récupération des infos de l'étudiant
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

if (!$student) {
    echo "Étudiant introuvable.";
    exit;
}

// Récupération de la wishlist
$wishlistStmt = $pdo->prepare("
    SELECT p.title FROM student_project_wishlist w
    JOIN projects p ON p.id = w.project_id
    WHERE w.student_id = ?
");
$wishlistStmt->execute([$id]);
$wishlist = $wishlistStmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails Étudiant</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
<div class="container">
    <h1>👤 Informations de l'Étudiant</h1>

    <p><strong>Nom :</strong> <?= htmlspecialchars($student['last_name']) ?></p>
    <p><strong>Prénom :</strong> <?= htmlspecialchars($student['first_name']) ?></p>
    <p><strong>Email :</strong> <?= htmlspecialchars($student['email']) ?></p>

    <h2>📜 Projets Souhaités</h2>
    <?php
    if (count($wishlist) === 0) {
        echo "<p>Aucun souhait enregistré.</p>";
    } else {
        echo "<ul>";
        foreach ($wishlist as $wish) {
            echo "<li>" . htmlspecialchars($wish['title']) . "</li>";
        }
        echo "</ul>";
    }
    ?>
    <p><a href="admin_students_list.php">⬅ Retour à la liste des étudiants</a></p>
</div>
</body>
</html>
