<?php
require 'vendor/autoload.php'; 

use Symfony\Component\Yaml\Yaml;


try {
    $contenu = Yaml::parseFile('data/competences.yaml');
} catch (Exception $e) {
    echo 'Erreur lors du chargement du fichier YAML: ',  $e->getMessage();
    exit;
}

$utilisateur = $contenu['utilisateur'] ?? [];
$competences = $utilisateur['competences'] ?? [];
?>

<section id="page2" class="page page-competences">
    <div class="container">
    <div class="circleComp circle-top-competences"></div>
    <div class="circleComp circle-bottom-competences"></div>
        <div class="competences">
            <h1>COMPÉTENCES</h1>
            <?php
               
                foreach ($competences as $competence_domaine) {
                   
                    $domaine = htmlspecialchars($competence_domaine['domaine']);
                    echo "<h2>$domaine</h2>";

                   
                    foreach ($competence_domaine['competences'] as $comp) {
                        $compName = htmlspecialchars($comp['nom']);
                        $niveau = (int)$comp['niveau']; 

                        echo "<div class='skill'>";
                        echo "<span class='skill-name'>$compName</span>";
                        echo "<div class='progress-bar'><div class='progress' style='width: $niveau%;'></div></div>";
                        echo "</div>";
                    }
                }
            ?>
        </div>
        <div class="photo">
            <img src="./assets/images/moicomplet.png" alt="Photo du profil">
        </div>
    </div>
</section>
