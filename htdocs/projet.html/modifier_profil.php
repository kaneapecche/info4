<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php 

var_dump($_SESSION);
exit();
if (!isset($_SESSION['login'])) {
    header("Location: connexion.php");
    exit();
}

$user_login = $_SESSION['login'];
$fichier = 'donnees/utilisateurs.csv';
$temp_fichier = 'donnees/temp_utilisateurs.csv';

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nouveau_nom = $_POST['nom'];
    $nouveau_prenom = $_POST['prenom'];
    $nouveau_email = $_POST['email'];
    $nouveau_telephone = $_POST['phone'];
    $nouvelle_date = $_POST['birthday'];
    $nouveau_genre = $_POST['genre'];
    $nouveau_mdp = $_POST['password'];

    $updated = false;

    if (($handle = fopen($fichier, "r")) !== FALSE && ($temp = fopen($temp_fichier, "w")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            if ($data[6] == $user_login) { 
                $data = [$nouveau_nom, $nouveau_prenom, $nouveau_email, $nouveau_telephone, $nouvelle_date, $nouveau_genre, $user_login, $nouveau_mdp];
                $updated = true;
            }
            fputcsv($temp, $data, ";");
        }
        fclose($handle);
        fclose($temp);

        if ($updated) {
            rename($temp_fichier, $fichier); // Remplace l'ancien fichier
            header("Location: profil.php"); // Redirige vers le profil après mise à jour
            exit();
        } else {
            unlink($temp_fichier); // Supprime le fichier temporaire si aucun changement
        }
    }
}
header("Location: profil.php?edit=true");
exit();
?>
</body>
</html>
