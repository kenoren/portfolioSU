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
?>

<section id="page2" class="page page-competences">
    <div class="container">
        <div class="competences">
            <h1>COMPETENCES</h1>
            <?php
                // Génération des barres de progression pour les compétences
                foreach ($competences as $competence) {
                    $comp = htmlspecialchars($competence['nom']);
                    $niveau = (int)$competence['niveau']; // S'assurer que le niveau est un entier

                    echo "<div class='skill'>";
                    echo "<span class='skill-name'>$comp</span>";
                    echo "<div class='progress-bar'><div class='progress' style='width: $niveau%;'></div></div>";
                    echo "</div>";
                }
            ?>
        </div>
        <div class="photo">
            <img src="./assets/images/moicomplet.png" alt="Photo du profil">
        </div>
    </div>
</section>

