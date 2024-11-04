<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compétences</title>
    <link rel="stylesheet" href="../assets/pages/accueil.css">
</head>
<body>
<header class="navbar">
        <div class="logo">
            <img src="../assets/images/logo.png" alt="Logo">
        </div>
        <nav>
            <a href="./porfolio.php">Accueil</a>
            <a href="pages/accueil.php">Compétences</a>
            <a href="#">Réalisations</a>
            <a href="#">Formation</a>
            <a href="#">Contact</a>
        </nav>
    </header>
    <div class="container">
        <div class="competences">
            <h1>COMPETENCES</h1>
            <?php
                // Liste des compétences et leurs niveaux (en pourcentage)
                $competences = [
                    "HTML" => 80,
                    "CSS" => 70,
                    "JS" => 60,
                    "PHP" => 50,
                    "FIGMA" => 65
                ];

                // Génération des barres de progression
                foreach ($competences as $comp => $level) {
                    echo "<div class='skill'>";
                    echo "<span class='skill-name'>$comp</span>";
                    echo "<div class='progress-bar'><div class='progress' style='width: $level%;'></div></div>";
                    echo "</div>";
                }
            ?>
        </div>
        <div class="photo">
            <img src="../assets/images/moicomplet.png" alt="Photo du profil">
        </div>
    </div>
</body>
</html>
