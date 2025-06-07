<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="container">
        <h2>Connexion Admin</h2>
        <form method="post" action="backend/login_admin.php">
            <label>Email</label>
            <input type="email" name="email" placeholder="admin@univ.dz" required>

            <label>Mot de passe</label>
            <input type="password" name="password" placeholder="Mot de passe" required>

            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>
