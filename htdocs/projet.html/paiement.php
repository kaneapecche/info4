<?php
session_start();

if (!isset($_GET['id'])) {
    die("Erreur : ID du voyage non spécifié.");
}

$id_voyage = $_GET['id'];

// Charger les voyages
$json = file_get_contents('donnees/voyages.json');
$voyages = json_decode($json, true);

if (!$voyages) {
    die("Erreur : Impossible de charger les données des voyages.");
}

// Trouver le voyage correspondant
$voyage = null;
foreach ($voyages as $v) {
    if (isset($v['id']) && $v['id'] == $id_voyage) {
        $voyage = $v;
        break;
    }
}

if (!$voyage) {
    die("Erreur : Voyage introuvable.");
}

// Vérifier la personnalisation
if (!isset($_SESSION['personnalisation'][$id_voyage])) {
    die("Erreur : Aucune personnalisation enregistrée pour ce voyage.");
}

$personnalisation = $_SESSION['personnalisation'][$id_voyage];

// Calculer le montant total
$totalPrix = 0;
foreach ($voyage['etapes'] as $index => $etape) {
    if (isset($personnalisation['etapes_selectionnees'][$index])) {
        $nbPersonnes = intval($personnalisation['nb_personnes'][$index] ?? 1);
        $totalPrix += (float) $etape['prix'] * $nbPersonnes;
    }
}

// Informations du paiement
$transaction_id = uniqid();
$vendeur = "MI-1_A";
$retour_url = "paiement_confirmation.php";
include_once('getAPIKey.php');
$api_key = getAPIKey($vendeur);
$control = md5($transaction_id . "#" . $totalPrix . "#" . $vendeur . "#" . $retour_url . "#");

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement du voyage</title>
    <link rel="stylesheet" href="projet.css/root.css">
    <link rel="stylesheet" href="projet.css/voyages.css">
</head>
<body>

<h2>🛒 Récapitulatif du paiement</h2>
<p><strong>Voyage :</strong> <?= htmlspecialchars($voyage['titre']); ?></p>
<p><strong>Montant total :</strong> <?= number_format($totalPrix, 2, '.', ''); ?> €</p>

<form action="transaction.php" method="POST">
    <input type="hidden" name="transaction" value="<?= $transaction_id; ?>">
    <input type="hidden" name="montant" value="<?= $totalPrix; ?>">
    <input type="hidden" name="vendeur" value="<?= $vendeur; ?>">
    <input type="hidden" name="retour" value="<?= $retour_url; ?>">
    <input type="hidden" name="control" value="<?= $control; ?>">
    
    <button type="submit">Procéder au paiement</button>
</form>

</body>
</html>

