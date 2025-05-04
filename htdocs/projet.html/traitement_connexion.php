<?php
session_start();

$csvFile = 'donnees/utilisateurs.csv';
$tempFile = 'temp_utilisateurs.csv';

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');
$found = false;

if (($handle = fopen($csvFile, 'r')) !== false) {
    $tempHandle = fopen($tempFile, 'w');
    $header = fgetcsv($handle);
    fputcsv($tempHandle, $header); // Réécrit l'en-tête dans le fichier temporaire

    while (($data = fgetcsv($handle)) !== false) {
        // On compare l'e-mail et le mot de passe
        if (trim($data[2]) === $email && trim($data[7]) === $password) {
            // Authentification réussie
            $_SESSION['login'] = $data[6]; // login
            $_SESSION['nom'] = $data[0];   // nom
            $_SESSION['email'] = $data[2]; // email

            // Mise à jour de la date de dernière connexion
            $data[10] = date('Y-m-d H:i:s');
            $found = true;
        }

        fputcsv($tempHandle, $data);
    }

    fclose($handle);
    fclose($tempHandle);

    // Remplace le fichier original
    rename($tempFile, $csvFile);

    if ($found) {
$_SESSION['prenom'] = $data[1];
$_SESSION['phone'] = $data[3];
$_SESSION['birthday'] = $data[5];
$_SESSION['genre'] = $data[4];
$_SESSION['date_inscription'] = date('Y-m-d H:i:s');
$_SESSION['date_derniere_connexion'] = date('Y-m-d H:i:s');
$_SESSION['role'] = $role;

        header('Location: profil.php');
        exit();
    } else {
        echo "<p>Identifiants incorrects. <a href='connexion.php'>Réessayer</a></p>";
    }
} else {
    echo "<p>Erreur : impossible d’ouvrir le fichier utilisateur.</p>";
}
?>
