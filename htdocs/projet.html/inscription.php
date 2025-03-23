<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>SereniTrip</title>
   <link rel="shortcut icon" href="image/logo.png" type="image/x-icon">
   <link rel="stylesheet" href="projet.css/root.css">
   <link rel="stylesheet" href="projet.css/login.css">
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
            <li><a href="profil.php">Profil</a></li>
        </ul>
        </div>
    </div>
    <br>
   <div class="container">
      <fieldset class="center-form">
       <legend>Inscription</legend>
       <form action="https://www.cafe-it.fr/cytech/post.php" method="post" >
           <label for="nom">Nom:</label>
           <input class="fill" type="text" name="nom">
           <label for="prenom">Prenom:</label>
           <input class="fill" type="text" name="nom">
           <br>
           <label for="email">Adresse e-mail</label>
           <input class="fill" type="email" name="email">
           <br><br>
           <label for="birthday">Date de naissance</label>
           <input type="date" name="birthday" value="2023-06-03">
           <br><br>
           <label for="sexe">Genre</label>
           <input type="radio" name="sexe" value="femme" checked="checked">Femme
           <input type="radio" name="sexe" value="homme">Homme
           <br>
           <br>
           <label for="phone">Téléphone</label>
           <input class="fill" type="tel" name="phone">
           <br><br>
           <label for="password">Mot de passe</label>
           <input class="fill" type="password" name="password">
           <br><br>
           <input class="button" type="submit" value="s'inscrire" formaction="profil.php">
       </form>
       <ul class="center-list">
         <li><a href="connexion.php">incription</a></li>
       </ul>
   </fieldset>
</div>
</body>
</html>v