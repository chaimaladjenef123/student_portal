<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: ../student_login.php');
    exit;
}
include 'db.php';

$student_id = $_SESSION['student_id'];
$project_ids = $_POST['project_ids'] ?? [];

// Supprimer les anciennes entrées
$delete_stmt = $pdo->prepare("DELETE FROM student_project_wishlist WHERE student_id = ?");
$delete_stmt->execute([$student_id]);

// Insérer les nouvelles entrées
$insert_stmt = $pdo->prepare("INSERT INTO student_project_wishlist (student_id, project_id) VALUES (?, ?)");
foreach ($project_ids as $project_id) {
    $insert_stmt->execute([$student_id, $project_id]);
}

// Rediriger vers le tableau de bord
header('Location: ../student_dashboard.php');
exit;
?>
