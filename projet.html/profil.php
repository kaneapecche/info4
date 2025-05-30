<!DOCTYPE html>
<html lang="en">
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
            <li><a href="accueil.php">Accueil</a></li>
            <li><a href="présentation.php">Destination</a></li>
            <li><a href="connexion.php">Connexion</a></li>
        </ul>
        </div>
    </div>
    <br>
   <div class="container"><fieldset cvlass="center-form">
       <legend>Profil</legend>
       <form action="https://www.cafe-it.fr/cytech/post.php" method="post" >
           <label for="nom">Nom:</label>
           <input class="fill" type="text"  id="nom" name="nom" value="Le Breton" disabled>
           <input class="button" type="submit" value="✏️">
           <br/>
           <label for="prenom">Prenom:</label>
           <input class="fill" type="text" id="prenom" name="prenom" value="Caryl" disabled>
           <input class="button" type="submit" value="✏️">
           <br/>
           <label for="email">Adresse e-mail:</label>
           <input class="fill" type="email" id="email" name="email" value="caryl.le-breton1@cyu.fr" disabled>
           <input class="button" type="submit" value="✏️">
           <br/><br/>
           <label for="birthday">Date de naissance:</label>
           <input type="date" id="birthday" name="birthday" value="1983-09-27" disabled>
           <input class="button" type="submit" value="✏️">
           <br/><br/>
           <label for="sexe">Genre:</label>
           <input class="button" type="submit" value="✏️">
           <input type="radio" name="sexe" value="femme" disabled>Femme
           <input type="radio" name="sexe" value="homme" checked disabled>Homme
           <br/><br/>
           <label for="phone">Téléphone</label>
           <input class="fill" type="tel" id="phone" name="phone" value="0625784319" disabled>
           <input class="button" type="submit" value="✏️">
           <br/><br/>
           <label for="password">Mot de passe</label>
           <input class="fill" type="password" id="passeword" name="password" value="SummerTrip2025" disabled>
           <input class="button" type="submit" value="✏️">
           <br/><br/>
           <input class="button" type="submit" value="Modifier">
       </form>
       <h5>Si vous êtes administrateur :</h5>
       <ul class="center-list">
         <li><a href="admin.php">Administrateur</a></li>
       </ul>
   </fieldset></div>
</body>
</html>
