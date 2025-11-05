<?php
// Nom d'utilisateur et mot de passe corrects
$username = $_POST['username'];
$password = $_POST['password'];

$is_admin = ($username === 'admin' && $password === 'secret');
$is_user = ($username === 'user' && $password === 'utilisateur');

// Vérifier si l'utilisateur a envoyé des identifiants
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
    // Envoyer un header HTTP pour demander les informations
    header('WWW-Authenticate: Basic realm="Zone Protégée"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Vous devez entrer un nom d\'utilisateur et un mot de passe pour accéder à cette page.';
    exit;
}

// Vérifier les identifiants envoyés
if ($_SERVER['PHP_AUTH_USER'] !== $valid_username || $_SERVER['PHP_AUTH_PW'] !== $valid_password) {
    // Si les identifiants sont incorrects
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
    <?php if ($is_admin) { ?>
        <h1>Bienvenue sur la page protégée</h1>
        <p>Ceci est une page protégée par une authentification simple via le header HTTP</p>
        <p>C'est le serveur qui vous demande un nom d'utilisateur et un mot de passe via le header WWW-Authenticate</p>
        <p>Aucun système de session ou cookie n'est utilisé pour cet atelier</p>
        <p>Vous êtes connecté en tant que : <?php echo htmlspecialchars($_SERVER['PHP_AUTH_USER']); ?></p>
        <a href="../index.html">Retour à l'accueil</a>  
    <?php } ?>
    <?php if ($is_user) { ?>
        <h1>Bienvenue sur la page protégée</h1>
        <p>Ceci est une page protégée par une authentification simple via le header HTTP</p>
        <p>C'est le serveur qui vous demande un nom d'utilisateur et un mot de passe via le header WWW-Authenticate</p>
        <p>Aucun système de session ou cookie n'est utilisé pour cet atelier</p>
        <p>Vous êtes connecté en tant que : <?php echo htmlspecialchars($_SERVER['PHP_AUTH_USER']); ?></p>
        <a href="../index.html">Retour à l'accueil</a>  
    <?php } ?>
</body>
</html>
