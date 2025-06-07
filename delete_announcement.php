<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $stmt = $pdo->prepare("DELETE FROM announcements WHERE id = ?");
    $stmt->execute([$_POST['id']]);
}
header("Location: ../admin_dashboard.php");
exit;
