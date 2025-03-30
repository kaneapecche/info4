<?php 
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['edit'])) {
    $nouveau_nom = $_POST['nom'];
    $nouveau_prenom = $_POST['prenom'];
    $nouveau_email = $_POST['email'];
    $nouveau_telephone = $_POST['telephone'];
    $nouveau_birthday = $_POST['birthday'];
    $nouveau_genre = $_POST['genre'];
    $nouveau_password = $_POST['password'];

    $fichier = 'donnees/utilisateurs.csv';
    $temp_fichier = 'donnees/temp_utilisateurs.csv';
    $modifie = false;

    if (($handle = fopen($fichier, "r")) !== FALSE) {
        $temp_handle = fopen($temp_fichier, "w");

        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            if ($data[2] == $_SESSION['email']) { 
                $data[0] = $nouveau_nom;
                $data[1] = $nouveau_prenom;
                $data[2] = $nouveau_email;
                $data[3] = $nouveau_telephone;
                $data[4] = $nouveau_birthday;
                $data[5] = $nouveau_genre;
                $data[7] = $nouveau_password;
                $modifie = true;
            }
            fputcsv($temp_handle, $data, ";");
        }

        fclose($handle);
        fclose($temp_handle);

        if ($modifie && filesize($temp_fichier) > 0) {
            unlink($fichier);
            rename($temp_fichier, $fichier);
        } else {
            unlink($temp_fichier);
        }
    }
    $_SESSION['email'] = $nouveau_email;
    header("Location: profil.php");
    exit();
}
?>

<?php
include 'admin_view.php'; // Inclure la barre de navigation
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
                <?php if(isset($data[8]) && $data[8] == "admin"): ?>
                    <li><a href="admin.php">Admin</a></li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>
        </div>
    </div>
    <br>
    <?php 
        if (!isset($_SESSION['email'])) {
            header("Location: connexion.php");
            exit();
        }
        
        function getUserData($login) {
            $fichier = 'donnees/utilisateurs.csv';
            if (($handle = fopen($fichier, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    if ($data[2] == $login) {
                        fclose($handle);
                        return [
                            'nom' => $data[0],
                            'prenom' => $data[1],
                            'email' => $data[2],
                            'telephone' => $data[3],
                            'date_de_naissance' => $data[4],
                            'genre' => $data[5],
                            'mot_de_passe' => $data[7],
                            'role' => $data[8]
                        ];
                    }
                }
                fclose($handle);
            }
            return null;
        }
        
        $user = getUserData($_SESSION['email']);
        if (!$user) {
            echo "Utilisateur non trouvé.";
            exit();
        }
        $mode_edition = isset($_GET['edit']) && $_GET['edit'] == 'true';
    ?>
   <div class="container"><fieldset cvlass="center-form">
       <legend>Profil</legend>
       <form action="profil.php?edit=true.php" method="post" >
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
           <?php if (!$mode_edition): ?>
               <a href="profil.php?edit=true" class="button">Modifier</a>
           <?php else: ?>
               <input type="submit" class="button" value="Enregistrer">
           <?php endif; ?>
       </form>
   </fieldset></div>
</body>
</html>
