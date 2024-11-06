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
var_dump($realisations);
?>

<section id="page3" class="page page-realisations">
    <div class="container">
        <div class="realisations">
            <h1>Réalisations</h1>
            <img src="./assets/images/<?php echo htmlspecialchars($realisations[0]['image']) ?>">
            
    </div>
</section>
