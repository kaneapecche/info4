<?php

// Vérifier si l'utilisateur est connecté et récupérer son rôle
$user_role = null;
$email = isset($_SESSION['email']) ? $_SESSION['email'] : null;

if ($email) {
    // Si l'utilisateur est connecté, récupérer son rôle depuis le fichier CSV
    $fichier = 'donnees/utilisateurs.csv';
    if (($handle = fopen($fichier, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            // Chercher l'utilisateur par email
            if ($data[2] == $email) {
                $user_role = $data[8];  // Le rôle de l'utilisateur (admin ou autre)
                break;
            }
        }
        fclose($handle);
    }
}
?>
