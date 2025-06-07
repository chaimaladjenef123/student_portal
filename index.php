<?php include 'backend/db.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Student Portal</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
</head>
<body>
    <div class="container">
        <h1>🎓 Bienvenue au Accueil</h1>

        <div class="login-buttons">
            <a class="btn" href="admin_login.php">Connexion Admin</a>
            <a class="btn" href="student_login.php">Connexion Étudiant</a>
        </div>

        <h2>📢 Annonces Générales</h2>

        <div class="announcements-background">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php
                    $stmt = $pdo->query("SELECT * FROM announcements WHERE display = 'general' ORDER BY datetime DESC");
                    while ($row = $stmt->fetch()) {
                        echo "<div class='swiper-slide'>";
                        echo "<div class='announcement'>";
                        echo "<h3>{$row['title']}</h3>";
                        echo "<p>{$row['content']}</p>";
                        echo "<small>🕒 {$row['datetime']}</small>";
                        echo "</div>";
                        echo "</div>";
                    }
                    ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>

        <h2>📚 Annonces par Département</h2>
        <ul class="departments">
            <li><a href="computer_science.php">🖥️ Informatique</a></li>
            <li><a href="math.php">📐 Mathématiques</a></li>
            <li><a href="physics.php">🔬 Physique</a></li>
            <li><a href="chemistry.php">⚗️ Chimie</a></li>
        </ul>
    </div>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.swiper-container', {
            loop: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>
</body>
</html>
