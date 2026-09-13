<?php
if (isset($_ENV['JAWSDB_URL'])) {
    $url = parse_url($_ENV['JAWSDB_URL']);
    return [
        "serveur" => $url['host'],
        "port" => $url['port'],
        "base" => ltrim($url['path'], '/'),
        "utilisateur" => $url['user'],
        "motDePasse" => $url['pass'],
        "smtpHote" => $_ENV['SMTP_HOTE'],
        "smtpPort" => (int)$_ENV['SMTP_PORT'],
        "smtpUtilisateur" => $_ENV['SMTP_UTILISATEUR'],
        "smtpMotDePasse" => $_ENV['SMTP_MOTDEPASSE'],
        "environnement" => "production",
        "mongoUri" => $_ENV['MONGO_URI'],
        "mongoBase" => $_ENV['MONGO_BASE'],
    ];
} else {
    return require __DIR__ . "/configLocal.php";
}
?>