<?php
require 'vendor/autoload.php'; // Chargez l'autoloader de Composer

use Symfony\Component\Yaml\Yaml;

// Charger le contenu du fichier YAML
try {
    $contenu = Yaml::parseFile('data/data.yaml');
} catch (Exception $e) {
    echo 'Erreur lors du chargement du fichier YAML: ',  $e->getMessage();
    exit;
}

// Extraire les données utilisateur
$utilisateur = $contenu['utilisateur'] ?? []; // Ajoutez un fallback si 'utilisateur' n'existe pas
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($utilisateur['prenom'] . ' ' . $utilisateur['nom']); ?> - Développeur & UX/UI</title>
    
    <!-- Inclusion des deux fichiers CSS -->
    <link rel="stylesheet" href="./assets/portfolio.css">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<section id="page1" class="page page-accueil">
    <header class="navbar">
        <div class="logo">
            <img src="./assets/images/logo.png" alt="Logo">
        </div>
        <nav>
            <a href="#page1">Accueil</a>
            <a href="#page2">Compétences</a>
            <a href="#">Réalisations</a>
            <a href="#">Formation</a>
            <a href="#">Contact</a>
        </nav>
    </header>

    <!-- Section Accueil (Hero) -->
    <section id="hero" class="hero">
        <div class="circle circle-top"></div>
        <div class="circle circle-bottom"></div>

        <div class="hero-content">
            <span class="first-name"><?php echo htmlspecialchars($utilisateur['prenom']); ?></span>
            <div class="last-name-container">
                <span class="last-name"><?php echo htmlspecialchars(substr($utilisateur['nom'], 0, 3)); ?></span>
                <span class="highlight"><?php echo htmlspecialchars(substr($utilisateur['nom'], 3)); ?></span>
            </div>
            <p class="subtitle"><?php echo htmlspecialchars($utilisateur['sous_titre']); ?></p>
        </div>
        <div class="scroll-down">Scroll down</div>
        <div class="hero-image">
            <img src="<?php echo htmlspecialchars($utilisateur['image']); ?>" alt="<?php echo htmlspecialchars($utilisateur['prenom'] . ' ' . $utilisateur['nom']); ?>">
        </div>
    </section>
</section>

<section id="page2" class="page page-competences">
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
</section>
</body>
</html>
