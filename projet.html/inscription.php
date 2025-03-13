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
            <li><a href="accueil.php">Accueil</a></li>
            <li><a href="présentation.php">Destination</a></li>
            <li><a href="connexion.php">Connexion</a></li>
        </ul>
        </div>
    </div>
    <br>
   <div class="container"><fieldset class="center-form">
       <legend>Inscription</legend>
       <form action="verif_inscription.php" method="post" >
           <label for="nom">Nom:</label>
           <input class="fill" type="text" name="nom">
           <label for="prenom">Prenom:</label>
           <input class="fill" type="text" name="prenom">
           <br>
           <label for="email">Adresse e-mail</label>
           <input class="fill" type="email" name="email">
           <br>
           <label for="birthday">Date de naissance</label>
           <input type="date" name="birthday" value="2023-06-03">
           <label for="genre">Genre</label>
           <input type="radio" name="genre" value="femme" checked="checked">Femme
           <input type="radio" name="genre" value="homme">Homme
           <br>
           <label for="phone">Téléphone</label>
           <input class="fill" type="tel" name="phone">
           <br>
           <label for="password">Mot de passe</label>
           <input class="fill" type="password" name="password">
           <br>
           <input class="button" type="submit" value="s'inscrire">
       </form>
   </fieldset></div>
</body>
</html>
