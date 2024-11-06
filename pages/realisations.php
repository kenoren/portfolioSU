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
$utilisateur = $contenu['utilisateur'] ?? [];
$competences = $utilisateur['competences'] ?? [];
$realisations = $utilisateur['realisations'] ?? [];

?>

<section id="page3" class="page-realisations">
    <div class="container-realisations">
      <!-- Circles positioned in the background -->
      <div class="circleR circle-top-realisations"></div>
      <div class="circleR circle-bottom-realisations"></div>

      <!-- Title in bottom-right corner -->
      <h1 class="realisations-title">RÉALISATIONS</h1>

      <!-- Project images and captions -->
      <div class="projects">
        <?php foreach ($realisations as $realisation): ?>
          <div class="project">
            <img src="./assets/images/<?php echo htmlspecialchars($realisation['image']); ?>" alt="<?php echo htmlspecialchars($realisation['nom']); ?>">
            <span><?php echo htmlspecialchars($realisation['nom']); ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
</section>
