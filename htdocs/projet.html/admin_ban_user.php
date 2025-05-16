<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['email']) || !isset($data['ban'])) {
    echo json_encode(['success' => false, 'message' => 'Données invalides']);
    exit;
}

$email = $data['email'];
$newBanStatus = $data['ban'];
$fichier = 'utilisateurs.csv';

$rows = [];
$modifie = false;

if (($handle = fopen($fichier, "r")) !== FALSE) {
    while (($line = fgetcsv($handle, 1000, ";")) !== FALSE) {
        if ($line[2] === $email) {
            $line[11] = $newBanStatus;  // Colonne bannissement
            $modifie = true;
        }
        $rows[] = $line;
    }
    fclose($handle);
}

if ($modifie && ($handle = fopen($fichier, "w")) !== FALSE) {
    foreach ($rows as $row) {
        fputcsv($handle, $row, ";");
    }
    fclose($handle);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non trouvé ou erreur fichier']);
}
