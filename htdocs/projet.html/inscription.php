<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>SereniTrip</title>
   <link rel="shortcut icon" href="image/logo.png" type="image/x-icon">
   <link rel="stylesheet" href="projet.css/root.css">
   <link rel="stylesheet" href="projet.css/apart.css">
   <link id="theme-css" rel="stylesheet" href="projet.css/style-default.css">

</head>
<body>
   <select id="theme-switcher">
  <option value="projet.css/style-default.css">Clair</option>
  <option value="projet.css/style-dark.css">Sombre</option>
  <option value="projet.css/style-accessible.css">Malvoyant</option>
  </select>
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
       <legend>Inscription</legend>
       <form action="traitement_inscription.php" method="post" id="form-inscription">
           <label for="nom">Nom:</label>
           <input class="fill" type="text" name="nom" id="nom" required>

           <label for="prenom">Prenom:</label>
           <input class="fill" type="text" name="prenom" id="prenom" required>
           <br>

           <label for="email">Adresse e-mail</label>
           <input class="fill" type="email" name="email" id="email" required>
           <br>

           <label for="pseudo">Pseudo</label>
           <input class="fill" type="text" name="pseudo" id="pseudo" required>
           <br>

           <label for="birthday">Date de naissance</label>
           <input type="date" name="birthday" id="birthday" value="2023-06-03" required>

           <label for="genre">Genre</label>
           <input type="radio" name="genre" id="genre-femme" value="femme" checked> Femme
           <input type="radio" name="genre" id="genre-homme" value="homme"> Homme
           <br>

           <label for="phone">Téléphone</label>
           <input class="fill" type="tel" name="phone" id="phone" required>
           <br>

           <label for="password">Mot de passe</label>
           <input class="fill" type="password" name="password" id="password" required>
           <button type="button" id="toggle-password">👁️</button>
           <br>
           <div id="error-message" style="color: red;"></div>
           <input class="button" type="submit" value="s'inscrire">
       </form>
    </fieldset>
   </div>
   <script>
// Sélection des éléments
const form = document.getElementById('form-inscription');
const passwordInput = document.getElementById('password');
const togglePassword = document.getElementById('toggle-password');
const errorMessage = document.getElementById('error-message');

const fieldsWithCounter = ['email', 'pseudo', 'password']; // Champs à surveiller
const maxCharLimits = { email: 50, pseudo: 20, password: 20 }; // Exemple de limites

// Créer les compteurs de caractères
fieldsWithCounter.forEach(id => {
    const input = document.getElementById(id);
    const counter = document.createElement('small');
    counter.id = id + '-counter';
    counter.style.display = 'block';
    counter.style.fontSize = '12px';
    input.parentNode.insertBefore(counter, input.nextSibling);

    input.addEventListener('input', () => {
        const count = input.value.length;
        counter.textContent = `${count}/${maxCharLimits[id]} caractères`;
        if (count > maxCharLimits[id]) {
            counter.style.color = 'red';
        } else {
            counter.style.color = 'black';
        }
    });
});

// Afficher/Masquer le mot de passe
togglePassword.addEventListener('click', () => {
    const type = passwordInput.getAttribute('type');
    if (type === 'password') {
        passwordInput.setAttribute('type', 'text');
    } else {
        passwordInput.setAttribute('type', 'password');
    }
});

// Validation du formulaire
form.addEventListener('submit', function(event) {
    event.preventDefault(); // Bloquer l'envoi

    let valid = true;
    let messages = [];

    const nom = document.getElementById('nom').value.trim();
    const prenom = document.getElementById('prenom').value.trim();
    const email = document.getElementById('email').value.trim();
    const pseudo = document.getElementById('pseudo').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const password = document.getElementById('password').value.trim();

    if (nom === '' || prenom === '' || email === '' || pseudo === '' || phone === '' || password === '') {
        valid = false;
        messages.push('Tous les champs doivent être remplis.');
    }

    if (password.length < 6) {
        valid = false;
        messages.push('Le mot de passe doit contenir au moins 6 caractères.');
    }

    if (email.length > maxCharLimits.email || pseudo.length > maxCharLimits.pseudo || password.length > maxCharLimits.password) {
        valid = false;
        messages.push('Un ou plusieurs champs dépassent la limite de caractères autorisée.');
    }

    if (!/^\d{10}$/.test(phone)) {
        valid = false;
        messages.push('Le numéro de téléphone doit contenir exactement 10 chiffres.');
    }

    if (!valid) {
        errorMessage.innerHTML = messages.join('<br>');
    } else {
        errorMessage.innerHTML = '';
        form.submit(); // Tout est OK => on envoie le formulaire
    }
});
</script>
<script src="script_couleur.js"></script>

</body>
</html>
