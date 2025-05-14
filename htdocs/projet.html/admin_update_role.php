<?php
// Indique que la réponse sera au format JSON
header('Content-Type: application/json');

// Lit les données JSON envoyées via la requête HTTP POST (corps de la requête)
$data = json_decode(file_get_contents("php://input"), true);
// Vérifie que les champs nécessaires sont présents : email et role
if (!isset($data['email']) || !isset($data['role'])) {
    echo json_encode(['success' => false, 'message' => 'Données invalides']);
    exit;
}

$email = $data['email'];       // Email de l'utilisateur à modifier
$newRole = $data['role'];      // Nouveau rôle à attribuer
$fichier = 'donnees/utilisateurs.csv'; // Fichier source contenant les utilisateurs

$rows = [];      // Tableau pour stocker toutes les lignes du fichier
$modifie = false; // Indique si une ligne a été modifiée

// Ouvre le fichier CSV en lecture
if (($handle = fopen($fichier, "r")) !== FALSE) {
    // Parcourt chaque ligne du fichier CSV
    while (($line = fgetcsv($handle, 1000, ";")) !== FALSE) {
        // Si l'email correspond à l'utilisateur ciblé
        if ($line[2] === $email) {
            $line[8] = $newRole;  // Modifie la colonne du rôle
            $modifie = true;      // Marque comme modifié
        }
        // Ajoute la ligne (modifiée ou non) au tableau
        $rows[] = $line;
    }
    fclose($handle); // Ferme le fichier après lecture
}

// Réécrit tout le fichier CSV avec les lignes modifiées
if ($modifie && ($handle = fopen($fichier, "w")) !== FALSE) {
    foreach ($rows as $row) {
        fputcsv($handle, $row, ";"); // Réécrit chaque ligne avec le séparateur ;
    }
    fclose($handle); // Ferme le fichier après écriture

    // Renvoie une réponse JSON de su
