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
$formations = $utilisateur['formations'] ?? [];
?>

<section id="page4" class="page-formations">
    <h1 class="formations-title">FORMATIONS</h1>
    <div class="formations-container">
        <div class="circleF circle-top-formations"></div>
        <div class="circleF circle-bottom-formations"></div>
        
        <?php foreach ($formations as $formation): ?>
            <div class="formation-item">
                <!-- Afficher le logo de l'établissement -->
                <img src="./assets/images/<?php echo htmlspecialchars($formation['logo']); ?>" 
                     alt="<?php echo htmlspecialchars($formation['etablissement']); ?>" class="formation-icon">
                
                <!-- Nom de l'établissement -->
                <p class="formation-ecole"><?php echo htmlspecialchars($formation['etablissement']); ?></p>
                
                <!-- Nom de la formation -->
                <p class="formation-diplome"><?php echo htmlspecialchars($formation['nom']); ?></p>
                
                <!-- Date de début et de fin -->
                <p class="formation-dates">
                    <?php echo date("d M Y", strtotime($formation['date_debut'])) . " - " . date("d M Y", strtotime($formation['date_fin'])); ?>
                </p>
                
                <!-- Lieu de la formation -->
                <p class="formation-lieu"><?php echo htmlspecialchars($formation['lieu']); ?></p>
                
                <!-- Contenu de la formation -->
                <p class="formation-contenu"><?php echo nl2br(htmlspecialchars($formation['contenu'])); ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Lien vers le CV -->
    <div class="cv-link">
        <a href="./assets/document/<?php echo htmlspecialchars($utilisateur['cv_pdf']); ?>" target="_blank" class="cv-button">Télécharger mon CV</a>
    </div>
</section>
