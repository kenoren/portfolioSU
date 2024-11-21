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
    $captchaResponse = $_POST['g-recaptcha-response'] ?? '';

    // Si reCAPTCHA est vide (signifiant que l'utilisateur n'a pas coché la case)
    if (empty($captchaResponse)) {
        echo "<p class='error'>Veuillez vérifier que vous n'êtes pas un robot.</p>";
    } else {
        // Vérifier la réponse reCAPTCHA avec l'API Google
        $secretKey = '6Ld68YUqAAAAACb4Jy0Zryprw0Y9WMvtHw6TdM9k';  // Remplacez par votre vraie clé secrète
        $remoteIp = $_SERVER['REMOTE_ADDR'];

        // Créer une requête pour valider la réponse
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => $secretKey,
            'response' => $captchaResponse,
            'remoteip' => $remoteIp
        ];

        // Effectuer la requête HTTP POST
        $options = [
            'http' => [
                'method'  => 'POST',
                'content' => http_build_query($data),
                'header'  => "Content-Type: application/x-www-form-urlencoded\r\n"
            ]
        ];
        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $responseKeys = json_decode($response, true);

        // Vérifier si reCAPTCHA a réussi
        if (intval($responseKeys["success"]) !== 1) {
            echo "<p class='error'>Vérification reCAPTCHA échouée. Veuillez réessayer.</p>";
        } else {
            // Si la vérification réussit, envoyer l'email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'mathisfou@gmail.com';
                $mail->Password = 'stut njgr fhgh uwww';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom($email, $nom);
                $mail->addAddress($email_destinataire);
                $mail->isHTML(true);
                $mail->Subject = $objet;
                $mail->Body    = "Nom: $nom\nEmail: $email\nObjet: $objet\n\nMessage:\n$message";

                $mail->send();
                echo "<p class='confirmation'>$confirmation_message</p>";
            } catch (Exception $e) {
                echo "Le message n'a pas pu être envoyé. Erreur : {$mail->ErrorInfo}";
            }
        }
    }
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
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <!-- reCAPTCHA widget -->
            <div class="g-recaptcha" data-sitekey="6Ld68YUqAAAAADx11yUJmzZUHgtQ3QyVozazUuPQ"></div>

            <button type="submit" class="submit-button">Envoyer</button>
        </form>
    </div>
</section>

<!-- Charger le script reCAPTCHA -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
