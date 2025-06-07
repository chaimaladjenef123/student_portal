<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}
include 'backend/db.php';

// Récupération des annonces
$annonces = $pdo->query("SELECT * FROM announcements ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
// Récupération des projets
$projets = $pdo->query("SELECT * FROM projects ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/admin.css">
    
</head>
<body>
<div class="container my-5">
    <h1 class="text-center mb-4"><i class="bi bi-speedometer2"></i> Dashboard Admin</h1>

    <ul class="nav nav-tabs mb-4" id="adminTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="annonces-tab" data-bs-toggle="tab" data-bs-target="#annonces" type="button" role="tab">📢 Annonces</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="projets-tab" data-bs-toggle="tab" data-bs-target="#projets" type="button" role="tab">📂 Projets</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="wishlist-tab" data-bs-toggle="tab" data-bs-target="#wishlist" type="button" role="tab">📜 Wishlists</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="etudiants-tab" data-bs-toggle="tab" data-bs-target="#etudiants" type="button" role="tab">👥 Étudiants</button>
        </li>
    </ul>

    <div class="tab-content" id="adminTabsContent">
        <!-- ✅ Annonces -->
        <div class="tab-pane fade show active" id="annonces" role="tabpanel">
            <h3 class="mb-3">Créer une Annonce</h3>
            <form method="post" action="backend/add_announcement.php">
                <div class="mb-3">
                    <input type="text" class="form-control" name="title" placeholder="Titre de l'annonce" required>
                </div>
                <div class="mb-3">
                    <textarea class="form-control" name="content" placeholder="Contenu de l'annonce" required></textarea>
                </div>
                <div class="mb-3">
                    <select class="form-select" name="display" required>
                        <option value="general">Générale (Accueil)</option>
                        <option value="computer_science">Informatique</option>
                        <option value="math">Mathématiques</option>
                        <option value="physics">Physique</option>
                        <option value="chemistry">Chimie</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Publier</button>
            </form>
        </div>

        <!-- ✅ Projets -->
        <div class="tab-pane fade" id="projets" role="tabpanel">
            <h3 class="mb-3">Ajouter un Projet de Fin d'Études</h3>
            <form method="post" action="backend/add_project.php">
                <div class="mb-3">
                    <input type="text" class="form-control" name="title" placeholder="Titre du projet" required>
                </div>
                <div class="mb-3">
                    <textarea class="form-control" name="description" placeholder="Description du projet" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">Ajouter le projet</button>
            </form>
        </div>

        <!-- ✅ Wishlists -->
        <div class="tab-pane fade" id="wishlist" role="tabpanel">
            <h3 class="mb-3">Wish Lists des Étudiants</h3>
            <?php
            $stmt = $pdo->query("SELECT s.first_name, s.last_name, p.title 
                                 FROM student_project_wishlist w
                                 JOIN students s ON s.id = w.student_id
                                 JOIN projects p ON p.id = w.project_id
                                 ORDER BY s.last_name");

            while ($row = $stmt->fetch()) {
                $firstName = htmlspecialchars($row['first_name']);
                $lastName = htmlspecialchars($row['last_name']);
                $projectTitle = htmlspecialchars($row['title']);

                echo "<div class='alert alert-secondary'>";
                echo "<strong>$firstName $lastName</strong> souhaite : <em>$projectTitle</em>";
                echo "</div>";
            }
            ?>
        </div>

        <!-- ✅ Étudiants -->
        <div class="tab-pane fade" id="etudiants" role="tabpanel">
            <h3 class="mb-3">Gestion des Étudiants</h3>
            <a href="admin_students_list.php" class="btn btn-info">📋 Voir la liste des étudiants</a>
        </div>
    </div>
</div>

<!-- ✅ Bouton flottant -->
<button class="floating-btn" data-bs-toggle="modal" data-bs-target="#manageModal">
    <i class="bi bi-gear-fill"></i>
</button>

<!-- ✅ Fenêtre Modale de gestion -->
<div class="modal fade" id="manageModal" tabindex="-1" aria-labelledby="manageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Gérer les Annonces et Projets</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <h6>Annonces :</h6>
        <ul class="list-group mb-3">
            <?php foreach ($annonces as $annonce): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><strong><?= htmlspecialchars($annonce['title']) ?></strong></span>
                    <form method="post" action="backend/delete_announcement.php" class="m-0">
                        <input type="hidden" name="id" value="<?= $annonce['id'] ?>">
                        <button class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>

        <h6>Projets :</h6>
        <ul class="list-group">
            <?php foreach ($projets as $projet): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><strong><?= htmlspecialchars($projet['title']) ?></strong></span>
                    <form method="post" action="backend/delete_project.php" class="m-0">
                        <input type="hidden" name="id" value="<?= $projet['id'] ?>">
                        <button class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
