<?php
// Démarre la session PHP
session_start();

// Vérifie si l'utilisateur est connecté (présence de l'e-mail dans la session)
if (!isset($_SESSION['email'])) {
    header('Location: connexion.php'); // Redirige vers la page de connexion s'il n'est pas connecté
    exit();
}
// Récupère l'e-mail de l'utilisateur connecté depuis la session
$email = $_SESSION['email'];
$user_role = null; // Rôle de l'utilisateur (à déterminer)
$users = []; // Tableau pour stocker tous les utilisateurs

/ Chemin du fichier CSV contenant les utilisateurs
$fichier = 'donnees/utilisateurs.csv';
// Lecture du fichier CSV ligne par ligne
if (($handle = fopen($fichier, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
         // Si l'e-mail correspond à l'utilisateur connecté, on récupère son rôle
        if ($data[2] == $email) {
            $user_role = $data[8]; // Colonne 8 = rôle (Admin/User)
        }
        $users[] = $data; //On ajoute chaque utilisateur au tableau
    }
    fclose($handle); // Ferme le fichier
}

// Vérifie que l'utilisateur est ADMIN
if ($user_role !== 'Admin') {
    echo "<h1>⛔️ Accès interdit</h1>"; // Message d'erreur si l'utilisateur n'est pas Admin
    exit();
}

// Pagination
$utilisateurs_par_page = 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$total_utilisateurs = count($users) - 1; // Ignore la première ligne (headers)
$total_pages = ceil($total_utilisateurs / $utilisateurs_par_page);

$start = ($page - 1) * $utilisateurs_par_page;
$users_to_display = array_slice($users, $start + 1, $utilisateurs_par_page);

// Inclusion du fichier de la vue de l'admin  (tableau des utilisateurs) après avoir préparé les données
include 'admin_view.php';
?>
