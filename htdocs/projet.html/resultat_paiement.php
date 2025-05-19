<?php
// Vérifier si les données ont été reçues
if (!isset(
    $_POST['transaction'], $_POST['montant'], $_POST['vendeur'], $_POST['control'],
    $_POST['nom_du_titulaire'], $_POST['numero_carte'], $_POST['expiration'], $_POST['cryptogramme']
)) {
    die("Erreur : Données de transaction incomplètes.");
}

// Récupérer les données
$transaction_id = $_POST['transaction'];
$montant = $_POST['montant'];
$vendeur = $_POST['vendeur'];
$control_recu = $_POST['control'];

$nom_titulaire = $_POST['nom_du_titulaire'];
$numero_carte = preg_replace('/\s+/', '', $_POST['numero_carte']); // Supprimer les espaces
$expiration = $_POST['expiration'];
$cryptogramme = $_POST['cryptogramme'];

// Vérification des coordonnées bancaires
$carte_valide = '5555123456789000';
$crypto_valide = '555';

if ($numero_carte === $carte_valide && $cryptogramme === $crypto_valide) {
    $status = "accepted";
} else {
    $status = "refused";
}

// Vérifier le contrôle (sécurité)
$control_calculé = md5($transaction_id . "#" . $montant . "#MI-1_A#" . $status . "#");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultat du paiement</title>
    <link rel="stylesheet" href="root.css">
    <link rel="stylesheet" href="voyages.css">
    <link id="theme-css" rel="stylesheet" href="style-default.css">
</head>
<body>
<select id="theme-switcher">
  <option value="style-default.css">Clair</option>
  <option value="style-dark.css">Sombre</option>
  <option value="style-accessible.css">Malvoyant</option>
</select>

<?php if ($status === "accepted") : ?>
    <h2>✅ Paiement validé !</h2>
    <p>Votre paiement de <?= number_format($montant, 2, '.', ''); ?> € a été accepté.</p>
    <a href="presentation.php">Retour à l'accueil</a>
<?php else : ?>
    <h2>❌ Paiement refusé</h2>
    <p>Le paiement a échoué. Veuillez vérifier vos informations et réessayer.</p>
    <a href="paiement.php?id=<?= $transaction_id; ?>">Réessayer</a>
<?php endif; ?>
<script src="script_couleur.js"></script>

</body>
</html>
