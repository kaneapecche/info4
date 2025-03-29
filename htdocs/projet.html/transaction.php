<?php 
// Vérifier si les données ont bien été reçues
if (!isset($_POST['transaction'], $_POST['montant'], $_POST['vendeur'], $_POST['retour'], $_POST['control'])) {
    die("Erreur : Données de transaction incomplètes.");
}

// Récupérer les données du formulaire
$transaction_id = $_POST['transaction'];
$montant = $_POST['montant'];
$vendeur = $_POST['vendeur'];
$retour_url = $_POST['retour'];
$control = $_POST['control'];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Informations de paiement</title>
    <link rel="stylesheet" href="root.css">
    <link rel="stylesheet" href="voyages.css">
</head>
<body>

<h2>💳 Entrez vos informations bancaires</h2>
<p><strong>Montant :</strong> <?= number_format($montant, 2, '.', ''); ?> €</p>

<form action="resultat_paiement.php" method="POST">
    <input type="hidden" name="transaction" value="<?= $transaction_id; ?>">
    <input type="hidden" name="montant" value="<?= $montant; ?>">
    <input type="hidden" name="vendeur" value="<?= $vendeur; ?>">
    <input type="hidden" name="control" value="<?= $control; ?>">

    <label for="nom_du_titulaire">Nom du titulaire :</label>
    <input type="text" id="nom_du_titulaire" name="nom_du_titulaire" required>

    <label for="numero_carte">Numéro de carte :</label>
    <input type="text" id="numero_carte" name="numero_carte" required>

    <label for="expiration">Date d'expiration :</label>
    <input type="text" id="expiration" name="expiration" required placeholder="MM/AA">

    <label for="cryptogramme">Cryptogramme :</label>
    <input type="text" id="cryptogramme" name="cryptogramme" required>

    <button type="submit">Valider et payer</button>
</form>

</body>
</html>

