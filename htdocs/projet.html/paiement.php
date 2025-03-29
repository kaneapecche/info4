<?php 
session_start();
include 'getapikey.php';
// Charger les données des voyages
$json = file_get_contents('voyages.json');
$voyages = json_decode($json, true);

// Recherche du voyage par ID
$voyage_trouver = null;
foreach ($voyages as $voyage) {
    if ($voyage['id'] == $voyages) {
        $voyage_trouver = $voyage;
        break;
    }
}

// Vérification des données du voyage
$titre = isset($voyage['titre']) ? htmlspecialchars($voyage['titre']) : "Non spécifié";
$date_debut = isset($voyage['dates']['debut']) ? htmlspecialchars($voyage['dates']['debut']) : "Non spécifié";
$date_fin = isset($voyage['dates']['fin']) ? htmlspecialchars($voyage['dates']['fin']) : "Non spécifié";
$montant = isset($voyage['prix']) ? number_format($voyage['prix'], 2, '.', '') : "0.00";

$transaction_id = uniqid();
$vendeur = "MI-1_A";
$retour_url = "http://localhost/paiement_confirmation.php"; // URL après paiement

// Générer le contrôle API
$control = md5($transaction_id . "#" . $montant . "#" . $vendeur . "#" . $retour_url . "#");

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement du voyage</title>
   <link rel="stylesheet" href="root.css">
   <link rel="stylesheet" href="login.css">
   <link rel="stylesheet" href="voyages.css">
</head>
</head>
<body>
    <h2>Paiement du voyage</h2>
    <p><strong>Voyage :</strong> <?= $titre; ?></p>
    <p><strong>Dates :</strong> <?= $date_debut . " - " . $date_fin; ?></p>
    <p><strong>Prix :</strong> <?= $montant; ?>€</p>

    <!-- Formulaire qui envoie vers une nouvelle page pour entrer les informations de la carte -->
    <form action="transaction.php" method="GET">
        <input type="hidden" name="transaction" value="<?= $transaction_id; ?>">
        <input type="hidden" name="montant" value="<?= $montant; ?>">
        <input type="hidden" name="vendeur" value="<?= $vendeur; ?>">
        <input type="hidden" name="retour" value="<?= $retour_url; ?>">
        <input type="hidden" name="control" value="<?= $control; ?>">

        <button type="submit">Valider et procéder au paiement</button>
    </form>
</body>
</html>
