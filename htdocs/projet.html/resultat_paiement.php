<?php
// Vérifier si les données ont été reçues
if (!isset($_POST['transaction'], $_POST['montant'], $_POST['vendeur'], $_POST['control'])) {
    die("Erreur : Données de transaction incomplètes.");
}

// Simuler un paiement aléatoire (à remplacer par une vraie API)
$status = (rand(0, 1) === 1) ? "accepted" : "refused";

// Vérifier le contrôle (sécurité)
$transaction_id = $_POST['transaction'];
$montant = $_POST['montant'];
$control_recu = $_POST['control'];
$control_calculé = md5($transaction_id . "#" . $montant . "#MI-1_A#" . $status . "#");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultat du paiement</title>
    <link rel="stylesheet" href="projet.css/root.css">
    <link rel="stylesheet" href="projet.css/voyages.css">
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
    <a href="paiement.php?id=<?= $_POST['transaction']; ?>">Réessayer</a>
<?php endif; ?>
<script src="script_couleur.js"></script>

</body>
</html>
