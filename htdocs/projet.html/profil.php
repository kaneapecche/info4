<?php session_start() ?>
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
<?php
// Vérifier si des données ont bien été envoyées
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération des données du formulaire
    $nom = $_POST["nom"] ?? "";
    $prenom = $_POST["prenom"] ?? "";
    $email = $_POST["email"] ?? "";
    $tel = $_POST["phone"] ?? "";
    $birthday = $_POST["birthday"] ?? "";
    $genre = $_POST["genre"] ?? "";
    $login = $_POST["pseudo"] ?? "";
    $password = $_POST["password"] ?? "";

    // Ouvrir le fichier CSV
    $file = "donnees/utilisateurs.csv";
    $userExistant = false;

    if (!file_exists($file)) {
        touch($file); // Crée le fichier s'il n'existe pas
    }

    $user = fopen($file, "a+"); // Ouverture en lecture et écriture
    if ($user) {
        // Lire et vérifier si l'utilisateur existe déjà
        rewind($user); // Repositionner le curseur au début du fichier
        fgetcsv($user, 10000, ';'); // Lire et ignorer la première ligne (l'en-tête)
        while (($info = fgetcsv($user, 10000, ';')) !== false) {
            if (count($info) < 7) continue; // Éviter les lignes incomplètes

            if ($login === $info[6] || $email === $info[2] || $tel === $info[3]) {
                $userExistant = true;
                header("Location: inscription.php");
                break; // Pas besoin de continuer à lire
            }
        }

        // Ajouter l'utilisateur s'il n'existe pas encore
        if (!$userExistant) {
            fputcsv($user, [$nom, $prenom, $email, $tel, $birthday, $genre, $login, $password], ';');
        }

        fclose($user);
        $_SESSION["login"] = $login;
        $_SESSION["email"] = $email;
        $_SESSION["tel"] = $tel;
    
        // Redirection vers la page d'accueil ou le profil
        header("Location: accueil.php");
        exit();
    } else {
        echo "Erreur lors de l'ouverture du fichier.";
    }
}
?>

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
            header("Location: login.php"); // Redirige vers la connexion si non connecté
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
           <input class="button" type="submit" value="✏️">
           <br/>
           <label for="prenom">Prenom:</label>
           <input class="fill" type="text" id="prenom" name="prenom" value=<?= htmlspecialchars($user['prenom']) ?> disabled>
           <input class="button" type="submit" value="✏️">
           <br/>
           <label for="email">Adresse e-mail:</label>
           <input class="fill" type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" disabled>
           <input class="button" type="submit" value="✏️">
           <br/><br/>
           <label for="birthday">Date de naissance:</label>
           <input type="date" id="birthday" name="birthday" value="<?= htmlspecialchars($user['date_de_naissance']) ?>" disabled>
           <input class="button" type="submit" value="✏️">
           <br/><br/>
           <label for="genre">Genre:</label>
           <input type="radio" name="genre" value="femme" <?= $user['genre'] == 'femme' ? 'checked' : '' ?> disabled>Femme
           <input type="radio" name="genre" value="homme" checked <?= $user['genre'] == 'homme' ? 'checked' : '' ?> disabled>Homme
           <input class="button" type="submit" value="✏️">
           <br/><br/>
           <label for="phone">Téléphone</label>
           <input class="fill" type="tel" id="phone" name="phone" value="<?= htmlspecialchars($user['telephone']) ?>" disabled>
           <input class="button" type="submit" value="✏️">
           <br/><br/>
           <label for="password">Mot de passe</label>
           <input class="fill" type="password" id="passeword" name="password" value="<?= htmlspecialchars($user['mot_de_passe']) ?>" disabled>
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
