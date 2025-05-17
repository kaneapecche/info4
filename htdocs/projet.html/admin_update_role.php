<?php
header('Content-Type: application/json');

// Lire la requête JSON
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['email']) || !isset($data['role'])) {
    echo json_encode(['success' => false, 'message' => 'Données invalides']);
    exit;
}

$email = $data['email'];
$newRole = $data['role'];
$fichier = 'donnees/utilisateurs.csv';

$rows = [];
$modifie = false;

// Lire le CSV et modifier le rôle
if (($handle = fopen($fichier, "r")) !== FALSE) {
    while (($line = fgetcsv($handle, 1000, ";")) !== FALSE) {
        if ($line[2] === $email) {
            $line[8] = $newRole;  // Colonne du rôle
            $modifie = true;
        }
        $rows[] = $line;
    }
    fclose($handle);
}

// Réécriture du fichier CSV
if ($modifie && ($handle = fopen($fichier, "w")) !== FALSE) {
    foreach ($rows as $row) {
        fputcsv($handle, $row, ";");
    }
    fclose($handle);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non trouvé ou erreur fichier']);
}
