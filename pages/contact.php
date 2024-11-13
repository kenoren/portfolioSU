<?php
require 'vendor/autoload.php';
use Symfony\Component\Yaml\Yaml;

// Charger le contenu YAML
try {
    $contenu = Yaml::parseFile('data/data.yaml');
} catch (Exception $e) {
    echo 'Erreur lors du chargement du fichier YAML: ', $e->getMessage();
    exit;
}

// Récupération des données de configuration du formulaire de contact
$utilisateur = $contenu['utilisateur'] ?? [];
$competences = $utilisateur['competences'] ?? [];
$realisations = $utilisateur['realisations'] ?? [];
$formations = $utilisateur['formations'] ?? [];
$formulaire = $utilisateur['contact']['formulaire']['champs'] ?? [];
$confirmation_message = $utilisateur['contact']['formulaire']['message_confirmation'] ?? '';
$email_destinataire = $utilisateur['contact']['envoi_email']['adresse_destinataire'] ?? '';
$sujet_defaut = $utilisateur['contact']['envoi_email']['sujet_par_defaut'] ?? '';

// Traitement de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $objet = $_POST['objet'] ?? $sujet_defaut;
    $message = $_POST['message'] ?? '';
    $captcha = $_POST['captcha'] ?? '';

    // Validation simple du captcha
    if ($captcha === '5') {  // Simple exemple de vérification
        // Envoi de l'email
        $mail_message = "Nom: $nom\nEmail: $email\nObjet: $objet\n\nMessage:\n$message";
        mail($email_destinataire, $objet, $mail_message, "From: $email");

        echo "<p class='confirmation'>$confirmation_message</p>";
    } else {
        echo "<p class='error'>Captcha incorrect. Veuillez réessayer.</p>";
    }
}
?>

<!-- Affichage du formulaire -->
<!-- Page de contact structurée comme la section Réalisations -->
<section id="page5" class="page-contact">
    <div class="container-contact">
        <h1 class="contact-title">Contactez-moi</h1>

        <form method="post" action="" class="contact-form">
            <?php foreach ($formulaire as $champ): ?>
                <div class="form-group">
                    <label for="<?php echo strtolower(str_replace(' ', '_', $champ['nom'])); ?>">
                        <?php echo htmlspecialchars($champ['nom']); ?><?php echo $champ['obligatoire'] ? '*' : ''; ?>
                    </label>

                    <?php if ($champ['type'] === 'text' || $champ['type'] === 'email'): ?>
                        <input type="<?php echo $champ['type']; ?>" 
                               id="<?php echo strtolower(str_replace(' ', '_', $champ['nom'])); ?>" 
                               name="<?php echo strtolower(str_replace(' ', '_', $champ['nom'])); ?>" 
                               required="<?php echo $champ['obligatoire'] ? 'required' : ''; ?>">
                    <?php elseif ($champ['type'] === 'textarea'): ?>
                        <textarea id="<?php echo strtolower(str_replace(' ', '_', $champ['nom'])); ?>" 
                                  name="<?php echo strtolower(str_replace(' ', '_', $champ['nom'])); ?>" 
                                  required="<?php echo $champ['obligatoire'] ? 'required' : ''; ?>"></textarea>
                    <?php elseif ($champ['type'] === 'captcha'): ?>
                        <input type="text" 
                               id="captcha" 
                               name="captcha" 
                               required="required" 
                               placeholder="Combien font 2 + 3 ?">
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <button type="submit" class="submit-button">Envoyer</button>
        </form>
    </div>
</section>
