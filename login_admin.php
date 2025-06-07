<?php 
session_start();
 include 'db.php'; 
 $stmt=$pdo->prepare('SELECT * FROM admins WHERE email=?');
  $stmt->execute([$_POST['email']]); $admin=$stmt->fetch(); 
  if($admin && $_POST['password']===$admin['password']){
     $_SESSION['admin_id']=$admin['id']; header('Location: ../admin_dashboard.php');
      } else { echo 'Erreur'; } ?>
