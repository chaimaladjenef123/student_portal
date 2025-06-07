<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: student_login.php');
    exit;
}
include 'backend/db.php';

$student_id = $_SESSION['student_id'];

// Récupérer les projets actuellement dans la liste de souhaits de l'étudiant
$stmt = $pdo->prepare("SELECT project_id FROM student_project_wishlist WHERE student_id = ?");
$stmt->execute([$student_id]);
$current_wishlist = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Récupérer tous les projets disponibles
$projects_stmt = $pdo->query("SELECT * FROM projects");
$projects = $projects_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier la Liste de Souhaits</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icônes Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h1 class="mb-4">Modifier votre Liste de Souhaits</h1>
    <form method="post" action="backend/update_wishlist.php">
        <div class="mb-3">
            <label for="projects" class="form-label">Sélectionnez vos projets préférés :</label>
            <select name="project_ids[]" id="projects" class="form-select" multiple required>
                <?php foreach ($projects as $project): ?>
                    <option value="<?= $project['id'] ?>" <?= in_array($project['id'], $current_wishlist) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($project['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <small class="form-text text-muted">Maintenez la touche Ctrl (Windows) ou Commande (Mac) enfoncée pour sélectionner plusieurs projets.</small>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour la Liste de Souhaits</button>
    </form>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
