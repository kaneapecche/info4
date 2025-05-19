<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ddd</title>
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
    $role = 'Utilisateur';
    $banni = 'Non';
    // Ouvrir le fichier CSV
    $file = "donnees/utilisateurs.csv";
    $userExistant = false;

    $date_inscription = date("Y-m-d H:i:s"); // Date actuelle
    $derniere_connexion = date("Y-m-d H:i:s"); // Mise à jour à chaque connexion


    if (!file_exists($file)) {
        touch($file); // Crée le fichier s'il n'existe pas
    }

    $user = fopen($file, "a+"); // Ouverture en lecture et écriture
    if ($user) {
        // Lire et vérifier si l'utilisateur existe déjà
        rewind($user); // Repositionner le curseur au début du fichier
        fgetcsv($user, 10000, ';'); // Lire et ignorer la première ligne (l'en-tête)
        while (($info = fgetcsv($user, 10000, ';')) !== false) {
            if (count($info) < 9) continue; // Éviter les lignes incomplètes

            if ($login === $info[6] || $email === $info[2] || $tel === $info[3]) {
                $userExistant = true;
                $info[8] = $derniere_connexion; // Mise à jour de la dernière connexion
                header("Location: inscription.php");
                break; // Pas besoin de continuer à lire
            }
        }

        // Ajouter l'utilisateur s'il n'existe pas encore
        if (!$userExistant) {
            fputcsv($user, [$nom, $prenom, $email, $tel, $genre, $birthday, $login, $password, $role, $date_inscription, $derniere_connexion, $banni], ';');
        }

        fclose($user);
        $_SESSION["login"] = $login;
        $_SESSION["email"] = $email;
        $_SESSION["tel"] = $tel;
    
        // Redirection vers la page d'accueil ou le profil
        header("Location: profil.php");
        exit();
    } else {
        echo "Erreur lors de l'ouverture du fichier.";
        header("Location: inscription.php");
    }
}
?>
</body>
</html>
