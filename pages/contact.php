<?php
// Inclure les fichiers nécessaires de PHPMailer en utilisant le chemin relatif correct
require 'C:\xampp\htdocs\portfolioSU\PHPMailer\src/PHPMailer.php';
require 'C:\xampp\htdocs\portfolioSU\PHPMailer\src/SMTP.php';
require 'C:\xampp\htdocs\portfolioSU\PHPMailer\src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Code pour charger YAML et traiter le formulaire
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
$formulaire = $utilisateur['contact']['formulaire']['champs'] ?? [];
$confirmation_message = $utilisateur['contact']['formulaire']['message_confirmation'] ?? '';
$email_destinataire = $utilisateur['contact']['envoi_email']['adresse_destinataire'] ?? '';
$sujet_defaut = $utilisateur['contact']['envoi_email']['sujet_par_defaut'] ?? '';

// Traitement de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['Nom'] ?? '';
    $email = $_POST['Email'] ?? '';
    $objet = $_POST['Objet'] ?? $sujet_defaut;
    $message = $_POST['Message'] ?? '';
    $captcha = $_POST['Captcha'] ?? '';

  

    // Validation simple du captcha
   //if ($captcha === '5') {  // Exemple de vérification
        // Configuration de PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Paramètres SMTP pour Gmail
            $mail->isSMTP();  // Utiliser SMTP
            $mail->Host = 'smtp.gmail.com';  // Serveur SMTP de Gmail
            $mail->SMTPAuth = true;  // Activer l'authentification SMTP
            $mail->Username = 'mathisfou@gmail.com';  // Votre email Gmail
            $mail->Password = 'Footbalesth3';  // Mot de passe ou mot de passe d'application (si 2FA activé)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Utiliser STARTTLS
            $mail->Port = 587;  // Port pour STARTTLS

            // Destinataire
            $mail->setFrom($email, $nom);  // De l'adresse email du formulaire
        
            $mail->addAddress($email_destinataire);  // À l'adresse email de destination

            // Contenu de l'email
            $mail->isHTML(true);  // Email au format HTML
            $mail->Subject = $objet;
            $mail->Body    = "Nom: $nom\nEmail: $email\nObjet: $objet\n\nMessage:\n$message";

            // Envoi de l'email
            $mail->send();
            echo "<p class='confirmation'>$confirmation_message</p>";  // Message de confirmation
        } catch (Exception $e) {
            echo "Le message n'a pas pu être envoyé. Erreur : {$mail->ErrorInfo}";  // Erreur d'envoi
        }
   /* } else {
        echo "<p class='error'>Captcha incorrect. Veuillez réessayer.</p>";  // Erreur de captcha
    }*/
}
?>


<!-- Affichage du formulaire -->
<section id="page5" class="page-contact">
    <div class="container-contact">
        <h1 class="contact-title">Contactez-moi</h1>

        <form method="post" action="" class="contact-form">
            <?php foreach ($formulaire as $champ): ?>
                <div class="form-group">
                    <label for="<?php echo str_replace(' ', '_', $champ['nom']); ?>">
                        <?php echo htmlspecialchars($champ['nom']); ?><?php echo $champ['obligatoire'] ? '*' : ''; ?>
                    </label>

                    <?php if ($champ['type'] === 'text' || $champ['type'] === 'email'): ?>
                        <input type="<?php echo $champ['type']; ?>" 
                               id="<?php echo str_replace(' ', '_', $champ['nom']); ?>" 
                               name="<?php echo str_replace(' ', '_', $champ['nom']); ?>" 
                               required="<?php echo $champ['obligatoire'] ? 'required' : ''; ?>">
                    <?php elseif ($champ['type'] === 'textarea'): ?>
                        <textarea id="<?php echo str_replace(' ', '_', $champ['nom']); ?>" 
                                  name="<?php echo str_replace(' ', '_', $champ['nom']); ?>" 
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