<?php 
// Récupérer les données envoyées depuis la page précédente
$transaction_id = isset($_GET['transaction']) ? $_GET['transaction'] : '';
$montant = isset($_GET['montant']) ? $_GET['montant'] : '';
$vendeur = isset($_GET['vendeur']) ? $_GET['vendeur'] : '';
$retour_url = isset($_GET['retour']) ? $_GET['retour'] : '';
$control = isset($_GET['control']) ? $_GET['control'] : '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire de paiement</title>
    <link rel="stylesheet" href="root.css">
   <link rel="stylesheet" href="login.css">
   <link rel="stylesheet" href="voyages.css">
   <link rel="stylesheet" href="apart.css">
</head>
<body>
    <h2>Informations de paiement</h2>
    <p><strong>Montant :</strong> <?= $montant; ?>€</p>
    <p><strong>Transaction ID :</strong> <?= $transaction_id; ?></p>

    <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
        <input type="hidden" name="transaction" value="<?= $transaction_id; ?>">
        <input type="hidden" name="montant" value="<?= $montant; ?>">
        <input type="hidden" name="vendeur" value="<?= $vendeur; ?>">
        <input type="hidden" name="retour" value="<?= $retour_url; ?>">
        <input type="hidden" name="control" value="<?= $control; ?>">

        <!-- Champ pour le numéro de la carte -->
        <div>
            <label for="nom_du_titulaire">Nom du titulaire :</label>
            <input type="text" id="nom_du_titulaire" name="nom_du_titulaire" required placeholder="Marie Antoinette Morue">
        </div><br>

        <div>
            <label for="numero_carte">Numéro de carte :</label>
            <input type="text" id="numero_carte" name="numero_carte" required placeholder="1234 1235 1456 98745">
        </div><br>

        <div>
            <label for="expiration">Date d'expiration :</label>
            <input type="text" id="expiration" name="expiration" required placeholder="MM/AA">
        </div><br>

        <div>
            <label for="cryptogramme">Cryptogramme :</label>
            <input type="text" id="cryptogramme" name="cryptogramme" required placeholder="255">
        </div><br>

        <button type="submit">Valider et payer</button>
    </form>
</body>
</html>
