<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: student_login.php');
    exit;
}
include 'backend/db.php';
$student_id = $_SESSION['student_id'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Étudiant</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icônes Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Votre CSS personnalisé -->
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
<div class="container my-5">
    <h1 class="text-center mb-4">🎓 Dashboard Étudiant</h1>

    <!-- Onglets de navigation -->
    <ul class="nav nav-tabs mb-4" id="studentTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="wishlist-tab" data-bs-toggle="tab" data-bs-target="#wishlist" type="button" role="tab" aria-controls="wishlist" aria-selected="true">📤 Soumettre une Liste de Souhaits</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="projects-tab" data-bs-toggle="tab" data-bs-target="#projects" type="button" role="tab" aria-controls="projects" aria-selected="false">📂 Projets Disponibles</button>
        </li>
    </ul>

    <!-- Contenu des onglets -->
    <div class="tab-content" id="studentTabsContent">
        <!-- Onglet Soumettre une Liste de Souhaits -->
        <div class="tab-pane fade show active" id="wishlist" role="tabpanel" aria-labelledby="wishlist-tab">
            <h2 class="mb-3">📜 Soumettre une Liste de Souhaits</h2>
            <form method="post" action="backend/submit_wishlist.php">
                <div class="mb-3">
                    <label for="project" class="form-label">Sélectionnez un projet :</label>
                    <select name="project_id" class="form-select" required>
                        <?php
                        // Récupérer les projets disponibles dans la base de données
                        $stmt = $pdo->query("SELECT * FROM projects");
                        while ($row = $stmt->fetch()) {
                            echo "<option value='{$row['id']}'>" . htmlspecialchars($row['title']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Soumettre</button>
            </form>
        </div>

        <!-- Onglet Projets Disponibles -->
        <div class="tab-pane fade" id="projects" role="tabpanel" aria-labelledby="projects-tab">
            <h2 class="mb-3">📂 Projets de Fin d'Études Disponibles</h2>
            <?php
            $stmt = $pdo->query("SELECT * FROM projects");
            while ($row = $stmt->fetch()) {
                echo "<div class='card mb-3'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . htmlspecialchars($row['title']) . "</h5>";
                echo "<p class='card-text'>" . htmlspecialchars($row['description']) . "</p>";
                echo "</div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</div>

<!-- Bouton flottant pour modifier la liste de souhaits -->
<button id="editWishlistBtn" class="btn btn-warning rounded-circle shadow-lg" style="position: fixed; bottom: 30px; right: 30px; z-index: 1000;">
    <i class="bi bi-pencil-square fs-4"></i>
</button>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('editWishlistBtn').addEventListener('click', function () {
    // Redirige vers la page de modification de la liste de souhaits
    window.location.href = 'edit_wishlist.php';
});
</script>
</body>
</html>
