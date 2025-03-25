<?php session_start(); ?>
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
    <?php 
        if (!isset($_SESSION['email'])) {
            header("Location: connexion.php"); // Redirige vers la connexion si non connecté
            exit();
        }
        $user_login = $_SESSION['login']; // L'email est utilisé comme identifiant unique
        
        function getUserData($login) {
            $fichier = 'donnees/utilisateurs.csv'; // Assure-toi que le chemin est correct
        
            if (($handle = fopen($fichier, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    if ($data[6] == $login) { // Comparer avec l'email de session
                        fclose($handle);
                        return [
                            'nom' => $data[0],
                            'prenom' => $data[1],
                            'email' => $data[2],
                            'telephone' => $data[3],
                            'date_de_naissance' => $data[4],
                            'genre' => $data[5],
                            'pseudo' => $data[6],
                            'mot_de_passe' => $data[7]
                        ];
                    }
                }
                fclose($handle);
            }
            return null; // Retourne null si l'utilisateur n'est pas trouvé
        }
        
        $user = getUserData($user_login);
        
        if (!$user) {
            echo "Utilisateur non trouvé.";
            exit();
        }
        
?>
   <div class="container"><fieldset cvlass="center-form">
       <legend>Profil</legend>
       <form action="https://www.cafe-it.fr/cytech/post.php" method="post" >
           <label for="nom">Nom:</label>
           <input class="fill" type="text"  id="nom" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" disabled>
           <button class="button" type="button">✏️</button>
           <br/>
           <label for="prenom">Prenom:</label>
           <input class="fill" type="text" id="prenom" name="prenom" value=<?= htmlspecialchars($user['prenom']) ?> disabled>
           <button class="button" type="button">✏️</button>
           <br/>
           <label for="email">Adresse e-mail:</label>
           <input class="fill" type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" disabled>
           <button class="button" type="button">✏️</button>
           <br/><br/>
           <label for="birthday">Date de naissance:</label>
           <input type="date" id="birthday" name="birthday" value="<?= htmlspecialchars($user['date_de_naissance']) ?>" disabled>
           <button class="button" type="button">✏️</button>
           <br/><br/>
           <label for="genre">Genre:</label>
           <input type="radio" name="genre" value="femme" <?= $user['genre'] == 'femme' ? 'checked' : '' ?> disabled>Femme
           <input type="radio" name="genre" value="homme" <?= $user['genre'] == 'homme' ? 'checked' : '' ?> disabled>Homme
           <button class="button" type="button">✏️</button>
           <br/><br/>
           <label for="phone">Téléphone</label>
           <input class="fill" type="tel" id="phone" name="phone" value="<?= htmlspecialchars($user['telephone']) ?>" disabled>
           <button class="button" type="button">✏️</button>
           <br/><br/>
           <label for="password">Mot de passe</label>
           <input class="fill" type="password" id="passeword" name="password" value="<?= htmlspecialchars($user['mot_de_passe']) ?>" disabled>
           <button class="button" type="button">✏️</button>
           <br/><br/>
           <button class="button" type="button">Modifier</button>
       </form>
       <h5>Si vous êtes administrateur :</h5>
       <ul class="center-list">
         <li><a href="admin.php">Administrateur</a></li>
       </ul>
   </fieldset></div>
</body>
</html>
