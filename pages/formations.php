<?php
require 'vendor/autoload.php'; 

use Symfony\Component\Yaml\Yaml;


try {
    $contenu = Yaml::parseFile('data/formations.yaml');
} catch (Exception $e) {
    echo 'Erreur lors du chargement du fichier YAML: ',  $e->getMessage();
    exit;
}


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
             
                <img src="./assets/images/<?php echo htmlspecialchars($formation['logo']); ?>" 
                     alt="<?php echo htmlspecialchars($formation['etablissement']); ?>" class="formation-icon">
                
           
                <p class="formation-ecole"><?php echo htmlspecialchars($formation['etablissement']); ?></p>
                
           
                <p class="formation-diplome"><?php echo htmlspecialchars($formation['nom']); ?></p>
                
               
                <p class="formation-dates">
                    <?php echo date("d M Y", strtotime($formation['date_debut'])) . " - " . date("d M Y", strtotime($formation['date_fin'])); ?>
                </p>
                
              
                <p class="formation-lieu"><?php echo htmlspecialchars($formation['lieu']); ?></p>
                
              
                <p class="formation-contenu"><?php echo nl2br(htmlspecialchars($formation['contenu'])); ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="cv-link">
        <a href="./assets/document/<?php echo htmlspecialchars($utilisateur['cv_pdf']); ?>" target="_blank" class="cv-button">Télécharger mon CV</a>
    </div>
</section>
