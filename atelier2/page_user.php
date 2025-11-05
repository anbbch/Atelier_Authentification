<?php
session_start();

// Si l'utilisateur a déjà un cookie valide
if (isset($_COOKIE['authToken']) && isset($_SESSION['authToken']) && $_COOKIE['authToken'] === $_SESSION['authToken']) {
    header('Location: page_user.php');
    exit();
}

// Gérer la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérification simple du username et du password
    if ($username === 'user' && $password === 'utilisateur') {
        // Génère un token sécurisé
        $token = bin2hex(random_bytes(16));

        // Stocke le token côté serveur (session)
        $_SESSION['authToken'] = $token;

        // Stocke le token côté client (cookie)
        setcookie('authToken', $token, [
            'expires' => time() + 3600, // 1 heure
            'path' => '/',
            'secure' => true,   // seulement via HTTPS
            'httponly' => true, // inaccessible en JS
            'samesite' => 'Strict'
        ]);

        header('Location: page_user.php');
        exit();
    } else {
        echo "Identifiants invalides.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h1>Atelier authentification par Cookie</h1>
    <h3>La page <a href="page_user.php">page_user.php</a> est inaccéssible tant que vous ne vous serez pas connecté avec le login 'user' et mot de passe 'utilisateur'</h3>
    <form method="POST" action="">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>
        <br><br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <button type="submit">Se connecter</button>
    </form>
    <br>
    <a href="../index.html">Retour à l'accueil</a>  
</body>
</html>
