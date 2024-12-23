<?php

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Symfony\Component\Yaml\Yaml;


try {
    $contenu = Yaml::parseFile('data/contact.yaml');
} catch (Exception $e) {
    echo 'Erreur lors du chargement du fichier YAML: ', $e->getMessage();
    exit;
}


$utilisateur = $contenu['utilisateur'] ?? [];
$formulaire = $utilisateur['contact']['formulaire']['champs'] ?? [];
$confirmation_message = $utilisateur['contact']['formulaire']['message_confirmation'] ?? '';
$email_destinataire = $utilisateur['contact']['envoi_email']['adresse_destinataire'] ?? '';
$sujet_defaut = $utilisateur['contact']['envoi_email']['sujet_par_defaut'] ?? '';


$confirmation = ''; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST['Nom'] ?? '';
    $email = $_POST['Email'] ?? '';
    $objet = $_POST['Objet'] ?? $sujet_defaut;
    $message = $_POST['Message'] ?? '';
    $captchaResponse = $_POST['g-recaptcha-response'] ?? '';
    $rgpdAccepted = isset($_POST['rgpd_accept']);

 
    if (!$rgpdAccepted) {
        $confirmation = "<p class='error'>Vous devez accepter les conditions liées à la collecte de vos données.</p>";
    } elseif (empty($captchaResponse)) {
        $confirmation = "<p class='error'>Veuillez vérifier que vous n'êtes pas un robot.</p>";
    } else {
       
        $secretKey = '6Ld68YUqAAAAACb4Jy0Zryprw0Y9WMvtHw6TdM9k';
        $remoteIp = $_SERVER['REMOTE_ADDR'];
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => $secretKey,
            'response' => $captchaResponse,
            'remoteip' => $remoteIp
        ];

        $options = [
            'http' => [
                'method'  => 'POST',
                'content' => http_build_query($data),
                'header'  => "Content-Type: application/x-www-form-urlencoded\r\n"
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $responseKeys = json_decode($response, true);

        if (intval($responseKeys["success"]) !== 1) {
            $confirmation = "<p class='error'>Vérification reCAPTCHA échouée. Veuillez réessayer.</p>";
        } else {
       
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
                $mail->Body = "
<html>
<head>
    <title>Message de Contact</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; color: #333; }
        .email-container { max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f4f4f4; border-radius: 8px; }
        .email-header { background-color: #4CAF50; color: #fff; padding: 10px; text-align: center; border-radius: 8px; }
        .email-content { background-color: #fff; padding: 20px; border-radius: 8px; border: 1px solid #ddd; }
        .email-content p { margin: 10px 0; }
        .email-content .label { font-weight: bold; color: #333; }
    </style>
</head>
<body>
    <div class='email-container'>
        <div class='email-header'>
            <h2>Message de Contact</h2>
        </div>
        <div class='email-content'>
            <p><span class='label'>Nom:</span> $nom</p>
            <p><span class='label'>Email:</span> $email</p>
            <p><span class='label'>Objet:</span> $objet</p>
            <p><span class='label'>Message:</span></p>
            <p>$message</p>
        </div>
    </div>
</body>
</html>
";
                $mail->send();
                $confirmation = "<p class='confirmation'>$confirmation_message</p>";
            } catch (Exception $e) {
                $confirmation = "<p class='error'>Le message n'a pas pu être envoyé. Erreur : {$mail->ErrorInfo}</p>";
            }
        }
    }
}
?>


<section id="page5" class="page-contact">
    <div class="container-contact">
    <div class="circleC circle-top-contact"></div>
    <div class="circleC circle-bottom-contact"></div>
        <div class="contact-left">
            <h1 class="contact-title">Contactez-moi</h1>
        </div>

        <div class="contact-right">
            <form id="contactForm" method="post" action="portfolio.php#page5" class="contact-form">
                <?php echo $confirmation; ?>

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

                        <?php if ($champ['type'] === 'rgpd'): ?>
                            <div class="form-group rgpd">
                                <input type="checkbox" id="rgpd_accept" name="rgpd_accept" required>
                                <label for="rgpd_accept"><?php echo htmlspecialchars($champ['texte']); ?></label>
                            </div>
                        <?php elseif ($champ['type'] === 'captcha'): ?>
                            <div class="g-recaptcha" data-sitekey="6Ld68YUqAAAAADx11yUJmzZUHgtQ3QyVozazUuPQ"></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <button type="submit" class="submit-button">Envoyer</button>
            </form>
        </div>
    </div>
</section>


<script src="https://www.google.com/recaptcha/api.js" async defer></script>



