<?php
session_start();

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['login'])) {
    header('Location: connexion.php');
    exit;
}
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$email = $_SESSION['email'];
$pseudo = $_SESSION['login'];
$phone = $_SESSION['phone'];
$birthday = $_SESSION['birthday'];
$genre = $_SESSION['genre'];
$date_inscription = $_SESSION['date_inscription'];
$date_derniere_connexion = $_SESSION['date_derniere_connexion'];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>SereniTrip</title>
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

            <?php if(!isset($_SESSION["email"])): ?>
                <li><a href="connexion.php">Connexion</a></li>
            <?php endif; ?>

            <?php if(isset($_SESSION["email"])): ?>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] == "Admin"): ?>
    <li><a href="admin.php">Admin</a></li>
<?php endif; ?>
            <?php endif; ?>
        </ul>
        </div>
    </div>
    <br>
    
   <div class="container">
       <fieldset class="center-form">
       <legend>Profil</legend>
       <form action="modifier_profil.php" method="post">
           <label for="nom">Nom:</label>
           <input class="fill" type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($nom); ?>" disabled>
           <button type="button" onclick="enableEdit('nom')">Modifier</button>
           <br/>
           <label for="prenom">Prenom:</label>
           <input class="fill" type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($prenom); ?>" disabled>
           <button type="button" onclick="enableEdit('prenom')">Modifier</button>
           <br/>
           <label for="email">Adresse e-mail:</label>
           <input class="fill" type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" disabled>
           <button type="button" onclick="enableEdit('email')">Modifier</button>
           <br/>
           <label for="pseudo">Pseudo:</label>
            <input class="fill" type="text" id="pseudo" name="pseudo" value="<?php echo htmlspecialchars($pseudo); ?>" disabled><br>
            <button type="button" onclick="enableEdit('pseudo')">Modifier</button>
            <br/>
           <label for="birthday">Date de naissance:</label>
           <input type="date" id="birthday" name="birthday" value="<?php echo htmlspecialchars($birthday); ?>" disabled>
           <button type="button" onclick="enableEdit('birthday')">Modifier</button>
           <br/><br/>
           <label for="genre">Genre:</label><br>
<input type="radio" name="genre" value="femme" <?php if ($genre == 'femme') echo 'checked'; ?>> Femme<br>
<input type="radio" name="genre" value="homme" <?php if ($genre == 'homme') echo 'checked'; ?>> Homme<br>
<button type="button" onclick="enableEdit('genre')">Modifier</button>
<br/><br/>
           <label for="telephone">Téléphone</label>
           <input class="fill" type="tel" id="telephone" name="telephone" value="<?php echo htmlspecialchars($phone); ?>" disabled>
           <button type="button" onclick="enableEdit('telephone')">Modifier</button>
           <br/><br/>
           <label for="password">Mot de passe</label>
<input class="fill" type="password" id="password" name="password" value="" disabled>
<button type="button" onclick="enableEdit('password')">Modifier</button>
<br/><br/>
           <div id="save-buttons" style="display:none;">
        <button type="submit">Enregistrer les modifications</button>
        <button type="button" onclick="cancelEdit()">Annuler</button>
        <button type="button" onclick="resetForm()">Réinitialiser</button>

    </div>
       </form>
       </fieldset>
   </div>
   <script type="text/javascript">
    let originalValues = {};

    function enableEdit(fieldId) {
    const field = document.getElementById(fieldId);
    if (!originalValues[fieldId]) {
        originalValues[fieldId] = field.value; // sauvegarde de la valeur initiale
    }
    field.disabled = false; // active le champ
    document.getElementById('save-buttons').style.display = 'block'; // montre les boutons de sauvegarde
}

function cancelEdit() {
    // Remet les champs à leur valeur d'origine
    for (const id in originalValues) {
        const field = document.getElementById(id);
        field.value = originalValues[id];
        field.disabled = true; // désactive les champs
    }
    originalValues = {};
    document.getElementById('save-buttons').style.display = 'none'; // cache les boutons
}
function resetForm() {
    const form = document.querySelector('form');
    form.reset(); // remet les valeurs du formulaire à l'état initial (DOM)
    
    // Réinitialiser aussi les radios (genre)
    const radios = document.querySelectorAll('input[type="radio"]');
    radios.forEach(r => r.disabled = false);

    // Réactiver tous les champs
    const inputs = form.querySelectorAll('input');
    inputs.forEach(input => {
        input.disabled = false;
    });

    document.getElementById('save-buttons').style.display = 'block'; // montre les boutons
}

</script>

</body>
</html>
