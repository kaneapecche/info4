<?php 
session_start();

// Vérifier si la session contient bien les informations du voyage
if (!isset($_SESSION['voyage']) || !is_array($_SESSION['voyage'])) {
    die("<h2>Erreur : Aucune donnée de voyage trouvée.</h2>");
}

$voyage = $_SESSION['voyage'];

// Vérifier les clés avant de les utiliser
$titre = isset($voyage['titre']) ? htmlspecialchars($voyage['titre']) : "Non spécifié";
$date_debut = isset($voyage['dates']['debut']) ? htmlspecialchars($voyage['dates']['debut']) : "Non spécifié";
$date_fin = isset($voyage['dates']['fin']) ? htmlspecialchars($voyage['dates']['fin']) : "Non spécifié";
$montant = isset($voyage['prix_total']) ? number_format($voyage['prix_total'], 2, '.', '') : "0.00";

$transaction_id = uniqid();
$vendeur = "MI-1_A";
$retour_url = "http://localhost/paiement.php";

// Générer le contrôle API
$control = md5($transaction_id . "#" . $montant . "#" . $vendeur . "#" . $retour_url . "#");

// Vérifier si c'est un retour de paiement de CY Bank
if (isset($_GET['status'])) {
    $status = $_GET['status']; // paiement accepté ou refusé
    $transaction = $_GET['transaction'];
    $montant_recu = $_GET['montant'];
    $control_recu = $_GET['control'];

    // Vérification de la validité des données
    $control_verif = md5($transaction . "#" . $montant_recu . "#" . $vendeur . "#" . $status . "#");

    if ($control_recu !== $control_verif) {
        die("<h2>Erreur de sécurité : données invalides.</h2>");
    }

    if ($status === "accepted") {
        // Enregistrer la transaction
        $paiements = json_decode('paiements.json') ? json_decode(file_get_contents('paiements.json'), true) : [];
        $paiements[] = [
            "utilisateur" => $_SESSION['login'],
            "voyage" => $_SESSION['voyage'],
            "montant" => $montant_recu,
            "transaction" => $transaction,
            "date" => date("Y-m-d H:i:s")
        ];
        file_put_contents('paiements.json', json_encode($paiements, JSON_PRETTY_PRINT));

        // Afficher la confirmation
        //recapitulatif si le paiement est accepter
        echo "<h2>Paiement validé</h2>";
        echo "<p>Votre réservation est confirmée.</p>";
        echo "<a href='profil.php'>Voir mes voyages</a>";
        exit();
    } else { // Si le paiement est refusé
        echo "<h2>Paiement refusé</h2>";
        echo "<p>Veuillez vérifier vos informations bancaires.</p>";
        echo "<a href='paiement.php'>Réessayer</a> ou <a href='voyage_personnalisation.php'>Modifier mon voyage</a>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement</title>
</head>
<body>
    <h2>Paiement du voyage</h2>
    <p><strong>Voyage :</strong> <?= $titre; ?></p>
    <p><strong>Dates :</strong> <?= $date_debut . " - " . $date_fin; ?></p>
    <p><strong>Prix :</strong> <?= $montant; ?>€</p>

    <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
        <input type="hidden" name="transaction" value="<?= $transaction_id; ?>">
        <input type="hidden" name="montant" value="<?= $montant; ?>">
        <input type="hidden" name="vendeur" value="<?= $vendeur; ?>">
        <input type="hidden" name="retour" value="<?= $retour_url; ?>">
        <input type="hidden" name="control" value="<?= $control; ?>">
        <button type="submit">Valider</button>
    </form>
</body>
</html>