<?php
require 'vendor/autoload.php'; // Chargez l'autoloader de Composer

use Symfony\Component\Yaml\Yaml;

// Charger le contenu du fichier YAML
try {
    $contenu = Yaml::parseFile('data/realisations.yaml');
} catch (Exception $e) {
    echo 'Erreur lors du chargement du fichier YAML: ',  $e->getMessage();
    exit;
}

// Extraire les données utilisateur
$utilisateur = $contenu['utilisateur'] ?? [];
$competences = $utilisateur['competences'] ?? [];
$realisations = $utilisateur['realisations'] ?? [];

?>

<section id="page3" class="page-realisations">
    <div class="container-realisations">
        <div class="circleR circle-top-realisations"></div>
        <div class="circleR circle-bottom-realisations"></div>

        <h1 class="realisations-title">RÉALISATIONS</h1>

        <div class="projects">
            <?php foreach ($realisations as $realisation): ?>
                <div class="project">
                    <a href="./assets/documents/<?php echo htmlspecialchars($realisation['document']); ?>" target="_blank">
                        <img src="./assets/images/<?php echo htmlspecialchars($realisation['illustration']); ?>" alt="<?php echo htmlspecialchars($realisation['titre']); ?>">
                    </a>
                    <h2><?php echo htmlspecialchars($realisation['titre']); ?></h2>
                    <p><?php echo htmlspecialchars($realisation['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>