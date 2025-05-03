<?php
session_start();

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['email']) || !isset($_SESSION['role'])) {
    header('Location: connexion.php');
    exit();
}

// Vérifie que c'est bien un VIP
if ($_SESSION['role'] !== 'VIP') {
    echo "<h1>⛔️ Accès interdit</h1>";
    exit();
}

$email = $_SESSION['email'];
$pseudo = $_SESSION['login'];
$tel = $_SESSION['tel'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace VIP - SereniTrip</title>
    <link rel="stylesheet" href="projet.css/root.css">
    <link rel="stylesheet" href="projet.css/apart.css">
    <link id="theme-css" rel="stylesheet" href="style-default.css">
</head>
<body>
<select id="theme-switcher">
  <option value="style-default.css">Clair</option>
  <option value="style-dark.css">Sombre</option>
  <option value="style-accessible.css">Malvoyant</option>
</select>
<div class="navigation">
    <img src="image/logo.png" alt="logo du site web" width="100" class="image">
    <div class="menu">
    <ul>
        <li><a href="accueil.php" class="button">Accueil</a></li>
        <li><a href="présentation.php">Destination</a></li>

        <?php if (!isset($_SESSION["login"])): ?>
            <li><a href="connexion.php">Connexion</a></li>
        <?php else: ?>
            <li><a href="profil.php">Profil</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        <?php endif; ?>
    </ul>
    </div>
</div>

<div class="container">
    <fieldset class="center-form">
        <legend>Espace VIP</legend>
        <p>🎉 Bienvenue <strong><?= htmlspecialchars($pseudo) ?></strong> !</p>
        <p>Vous êtes connecté en tant que <strong>VIP</strong>.</p>
        <p>Email : <?= htmlspecialchars($email) ?></p>
        <p>Téléphone : <?= htmlspecialchars($tel) ?></p>
        <br>
        <p>✨ Merci de faire partie de nos utilisateurs privilégiés !</p>
    </fieldset>
</div>
<script src="script_couleur.js"></script>

</body>
</html>
