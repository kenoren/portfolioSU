    <?php
    require 'vendor/autoload.php'; // Chargez l'autoloader de Composer

    use Symfony\Component\Yaml\Yaml;

    // Charger le contenu du fichier YAML
    try {
        $contenu = Yaml::parseFile('data/accueil.yaml');
    } catch (Exception $e) {
        echo 'Erreur lors du chargement du fichier YAML: ',  $e->getMessage();
        exit;
    }

    // Extraire les données utilisateur
    $utilisateur = $contenu['utilisateur'] ?? [];
    $competences = $utilisateur['competences'] ?? [];
    $realisations = $utilisateur['realisations'] ?? [];
    ?>

    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo htmlspecialchars($utilisateur['prenom'] . ' ' . $utilisateur['nom']); ?> - Développeur & UX/UI</title>
        
        <!-- Inclusion des deux fichiers CSS -->
        <link rel="stylesheet" href="./assets/portfolio.css">
        <link rel="stylesheet" href="./assets/pages/competences.css">
        <link rel="stylesheet" href="./assets/pages/realisations.css">
        <link rel="stylesheet" href="./assets/pages/formations.css">
        <link rel="stylesheet" href="./assets/pages/contact.css">

        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/typewriter-effect@2.18.0/dist/core.js"></script>



    </head>
    <body>
    <section id="page1" class="page page-accueil">
    <header class="navbar">
        <div class="logo">
            <img src="./assets/images/logo.png" alt="Logo">
        </div>

        <!-- Bouton hamburger pour le menu mobile -->
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <nav id="navbar">
            <a href="#page1">Accueil</a>
            <a href="#page2">Compétences</a>
            <a href="#page3">Réalisations</a>
            <a href="#page4">Formation</a>
            <a href="#page5">Contact</a>
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
            <!--<div class="scroll-down">Scroll down</div> -->
            <div class="hero-image">
                <img src="<?php echo htmlspecialchars($utilisateur['image']); ?>" alt="<?php echo htmlspecialchars($utilisateur['prenom'] . ' ' . $utilisateur['nom']); ?>">
            </div>

            <p class="presentation">
                <?php echo htmlspecialchars($utilisateur['description']); ?>
            </p>

        </section>
    </section>
    <?php include("./pages/competences.php")?>
    <?php include("./pages/realisations.php")?>
    <?php include("./pages/formations.php")?>
    <?php include("./pages/contact.php")?>

    <script src="./js/portfolio.js"></script>
    </body>
    </html>
