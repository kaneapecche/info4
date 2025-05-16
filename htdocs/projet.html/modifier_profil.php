<?php 
session_start(); 
header('Content-Type: application/json');

if (!isset($_SESSION["email"])) {
    echo json_encode(['success' => false, 'message' => 'Non connecté']);
    exit();
}

// Vérifie que toutes les données attendues sont présentes
$champs_requis = ['nom', 'prenom', 'email', 'telephone', 'birthday', 'genre', 'password'];
foreach ($champs_requis as $champ) {
    if (empty($_POST[$champ])) {
        echo json_encode(['success' => false, 'message' => "Champ manquant: $champ"]);
        exit();
    }
}

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
            $data[4] = $nouveau_genre;
            $data[5] = $nouveau_birthday;
            $data[7] = $nouveau_password;
            $modifie = true;
        }
        fputcsv($temp_handle, $data, ";");
    }

    fclose($handle);
    fclose($temp_handle);

    if ($modifie) {
        unlink($fichier);
        rename($temp_fichier, $fichier);
        $_SESSION['email'] = $nouveau_email;
        echo json_encode(['success' => true]);
    } else {
        unlink($temp_fichier);
        echo json_encode(['success' => false, 'message' => 'Utilisateur non trouvé']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur ouverture fichier']);
}
