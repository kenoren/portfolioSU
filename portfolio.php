<?php
require 'vendor/autoload.php'; // Chargez l'autoloader de Composer

use Symfony\Component\Yaml\Yaml;

// Charger le contenu du fichier YAML
$contenu = Yaml::parseFile('data/data.yaml');

// Extraire les données utilisateur
$utilisateur = $contenu['utilisateur'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $utilisateur['prenom'] . ' ' . $utilisateur['nom']; ?> - Développeur & UX/UI</title>
    <link rel="stylesheet" href="./assets/portfolio.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="navbar">
        <div class="logo">
            <img src="./assets/images/logo.png" alt="Logo">
        </div>
        <nav>
            <a href="#">Accueil</a>
            <a href="#">Compétences</a>
            <a href="#">Réalisations</a>
            <a href="#">Formation</a>
            <a href="#">Contact</a>
        </nav>
    </header>

    <section class="hero">
       <div class="hero-content">
           <span class="first-name"><?php echo $utilisateur['prenom']; ?></span>
           <div class="last-name-container">
               <span class="last-name"><?php echo substr($utilisateur['nom'], 0, 3); ?></span>
               <span class="highlight"><?php echo substr($utilisateur['nom'], 3); ?></span>
           </div>
           <p class="subtitle"><?php echo $utilisateur['sous_titre']; ?></p>
           <div class="scroll-down">Scroll down</div>
       </div>
       <div class="hero-image">
           <img src="<?php echo $utilisateur['image']; ?>" alt="<?php echo $utilisateur['prenom'] . ' ' . $utilisateur['nom']; ?>">
       </div>
   </section>
    
</body>
</html>
