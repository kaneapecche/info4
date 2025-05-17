<?php session_start(); ?>
<?php if (isset($_GET['message']) && $_GET['message'] == "connecte_pour_reserver"): ?>
    <p style="color: red; text-align: center;">⚠️ Vous devez vous connecter pour réserver un voyage.</p>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SereniTrip</title>
  <link rel="shortcut icon" href="logo.png" type="image/x-icon">
  <link rel="stylesheet" href="projet.css/root.css">
  <link rel="stylesheet" href="projet.css/apart.css">
</head>
<body>
    <div class="navigation">
        <img src="image/logo.png" alt="logo du site web" width="100" class="image">
        <div class="menu">
        <ul>
            <li><a href="accueil.php" class="button">Accueil</a></li>
            <li><a href="présentation.php">Destination</a></li>

            <?php if(!isset($_SESSION["login"])): ?>
                <li><a href="connexion.php">Connexion</a></li>
            <?php endif; ?>

            <?php if(isset($_SESSION["login"])): ?>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            <?php endif; ?>
        </ul>
        </div>
    </div>
    <br>
    <div class="container">
        <fieldset class="center-form">
        <legend>Connexion</legend>
        <form action="traitement_connexion.php<?php echo isset($_GET['redirect']) ? '?redirect=' . urlencode($_GET['redirect']) : ''; ?>" method="post">

            <label for="email">Adresse e-mail:</label>
            <input class="fill" type="text" name="email">
            <br>
            <label for="password">Mot de passe:</label>
            <input class="fill" type="password" name="password">
            <br>
            <input class="button" type="submit" value="sign in" >
        </form>
        
        <h5>Si vous n'êtes pas incrit :</h5>
        <ul class="center-list">
          <li><a href="inscription.php">incription</a></li>
        </ul>
        </fieldset>
    </div>
    <br>
    
    <script>
const formConnexion = document.querySelector('form');

formConnexion.addEventListener('submit', function(event) {
    const email = formConnexion.querySelector('input[name="email"]').value.trim();
    const password = formConnexion.querySelector('input[name="password"]').value.trim();

    if (email === '' || password === '') {
        event.preventDefault();
        alert('Veuillez remplir tous les champs avant de vous connecter.');
    }
});
</script>

</body>
</html>
