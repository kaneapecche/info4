<?php
session_start();

// Dossier où on stocke les utilisateurs
$fichier = 'donnees/utilisateurs.csv';

// Récupérer les données du formulaire
$nom = trim($_POST['nom']);
$prenom = trim($_POST['prenom']);
$email = trim($_POST['email']);
$pseudo = trim($_POST['pseudo']);
$birthday = trim($_POST['birthday']);
$genre = trim($_POST['genre']);
$phone = trim($_POST['phone']);
$password = trim($_POST['password']);
$role = 'Utilisateur';

// Validation simple
if (empty($nom) || empty($prenom) || empty($email) || empty($pseudo) || empty($password)) {
    die('Veuillez remplir tous les champs obligatoires.');
}

// Hacher le mot de passe pour la sécurité

// Vérifier que l'utilisateur n'existe pas déjà (email OU pseudo)
if (file_exists($fichier)) {
    $handle = fopen($fichier, 'r');
    while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
        if (
            (isset($data[2]) && $data[2] == $email) || 
            (isset($data[6]) && $data[6] == $pseudo)
        ) {
            fclose($handle);
            die('Erreur : Un compte avec cet email ou ce pseudo existe déjà.');
        }
        
    }
    fclose($handle);
}

// Enregistrer le nouvel utilisateur
$handle = fopen($fichier, 'a');
$date_inscription = date('Y-m-d H:i:s');
$date_derniere_connexion = $date_inscription; // Première connexion = inscription
$ligne = [$nom, $prenom, $email, $phone, $genre, $birthday, $pseudo, $password, $role, $date_inscription, $date_derniere_connexion, ];
fputcsv($handle, $ligne);
fclose($handle);

// Rediriger vers profil
$_SESSION['login'] = $_POST['pseudo'];
$_SESSION['nom'] = $_POST['nom'];
$_SESSION['prenom'] = $_POST['prenom'];
$_SESSION['email'] = $_POST['email'];
$_SESSION['phone'] = $_POST['phone'];
$_SESSION['birthday'] = $_POST['birthday'];
$_SESSION['genre'] = $_POST['genre'];
$_SESSION['date_inscription'] = date('Y-m-d H:i:s');
$_SESSION['date_derniere_connexion'] = date('Y-m-d H:i:s');
$_SESSION['role'] = $role;

header('Location: profil.php');
exit;
?>
