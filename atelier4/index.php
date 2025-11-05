<?php
// Définir les identifiants valides
$valid_admin_username = 'admin';
$valid_admin_password = 'secret';
$valid_user_username = 'user';
$valid_user_password = 'utilisateur';

// Vérifier si l'utilisateur a envoyé des identifiants
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
    // Envoyer un header HTTP pour demander les informations
    header('WWW-Authenticate: Basic realm="Zone Protégée"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Vous devez entrer un nom d\'utilisateur et un mot de passe pour accéder à cette page.';
    exit;
}
// Récupérer les identifiants envoyés
$username = $_SERVER['PHP_AUTH_USER'];
$password = $_SERVER['PHP_AUTH_PW'];

// Vérifier les identifiants admin ou user
$is_admin = ($username === $valid_admin_username && $password === $valid_admin_password);
$is_user  = ($username === $valid_user_username && $password === $valid_user_password);

// Si aucun des deux n’est correct
if (!$is_admin && !$is_user) {
    header('WWW-Authenticate: Basic realm="Zone Protégée"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Nom d\'utilisateur ou mot de passe incorrect.';
    exit;
}

// Si les identifiants sont corrects
?>
    
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page protégée</title>
</head>
<body>
    <h1>Bienvenue sur la page protégée</h1>
    <p>Ceci est une page protégée par une authentification simple via le header HTTP.</p>
    <p>C'est le serveur qui vous demande un nom d'utilisateur et un mot de passe via le header <code>WWW-Authenticate</code>.</p>
    <p>Aucun système de session ou cookie n'est utilisé pour cet atelier.</p>
    <p>Vous êtes connecté en tant que : <strong><?php echo htmlspecialchars($username); ?></strong></p>

    <?php if ($is_admin) { ?>
        <p>Rôle : <strong>Administrateur</strong></p>
    <?php } elseif ($is_user) { ?>
        <p>Rôle : <strong>Utilisateur</strong></p>
    <?php } ?>

    <a href="../index.html">Retour à l'accueil</a>
</body>
</html>
