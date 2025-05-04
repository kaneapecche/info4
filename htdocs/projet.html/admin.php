<?php
session_start();

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header('Location: connexion.php');
    exit();
}

$email = $_SESSION['email'];
$user_role = null;
$users = [];

// Charger les utilisateurs
$fichier = 'utilisateurs.csv';
if (($handle = fopen($fichier, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        if ($data[2] == $email) {
            $user_role = $data[8]; // Rôle dans la colonne 8 (index 7)
        }
        $users[] = $data;
    }
    fclose($handle);
}

// Vérifie que l'utilisateur est ADMIN
if ($user_role !== 'Admin') {
    echo "<h1>⛔️ Accès interdit</h1>";
    exit();
}

// Pagination
$utilisateurs_par_page = 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$total_utilisateurs = count($users) - 1; // Ignore la première ligne (headers)
$total_pages = ceil($total_utilisateurs / $utilisateurs_par_page);

$start = ($page - 1) * $utilisateurs_par_page;
$users_to_display = array_slice($users, $start + 1, $utilisateurs_par_page);

// Appelle la vue
include 'admin_view.php';
?>
