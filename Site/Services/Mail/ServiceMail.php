<?php
require_once __DIR__ . "/../../../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ServiceMail {
    public static function envoyer(string $destinataire, string $sujet, string $corps, ?string $repondreA = null): void {
        $configuration = require __DIR__ . "/../../Configuration/config.php";
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $configuration["smtpHote"];
            $mail->SMTPAuth = true;
            $mail->Username = $configuration["smtpUtilisateur"];
            $mail->Password = $configuration["smtpMotDePasse"];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $configuration["smtpPort"];
            $mail->setFrom($configuration["smtpUtilisateur"], "Vite & Gourmand");
            if ($repondreA !== null) {
                $mail->addReplyTo($repondreA);
            }
            $mail->addAddress($destinataire);
            $mail->isHTML(true);
            $mail->Subject = $sujet;
            $mail->Body = $corps;
            $mail->CharSet = 'UTF-8';

            /** Contournement temporaire pour passer outre le soucis de certificat */
            if ($configuration["environnement"] === "local") {
                $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    ]
                ];
            }

            $mail->send();
        } catch (Exception $e) {
            throw new Exception("L'email n'a pas pu être envoyé : " . $mail->ErrorInfo);
        }
    }
}
?>