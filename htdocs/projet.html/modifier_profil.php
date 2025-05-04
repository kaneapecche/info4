
<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: connexion.php');
    exit;
}

$login = $_SESSION['login'];
$new_nom = $_POST['nom'];
$new_prenom = $_POST['prenom'];
$new_email = $_POST['email'];
$new_phone = $_POST['phone'];
$new_password = $_POST['password'];

// Lecture de tous les utilisateurs
$users = array_map('str_getcsv', file('donnees/utilisateurs.csv'));

// Mise à jour
foreach ($users as &$user) {
    if ($user[6] === $login) { // 3 = pseudo
        $user[0] = $new_nom;
        $user[1] = $new_prenom;
        $user[2] = $new_email;
        $user[3] = $new_phone;
        $user[7] = $new_password; // ATTENTION : ici tu pourrais hasher le mot de passe pour plus de sécurité
        $user[10] = date('Y-m-d H:i:s'); // Mise à jour dernière modification
        break;
    }
}

// Réécriture du fichier CSV
$file = fopen('donnees/utilisateurs.csv', 'w');
foreach ($users as $user) {
    fputcsv($file, $user);
}
fclose($file);

header('Location: profil.php');
exit;
?>
