<?php
session_start();

$json = file_get_contents('donnees/voyages.json');
$voyages = json_decode($json, true);

if (!$voyages) {
    die("Erreur : Impossible de charger les données des voyages.");
}

$id_voyage = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($id_voyage === null) {
    die("Erreur : Aucun ID reçu dans l'URL.");
}


$voyage = null;
foreach ($voyages as $v) {
    if (isset($v['id']) && $v['id'] == $id_voyage) {
        $voyage = $v;
        break;
    }
}

if (!$voyage) {
    die("Erreur : Aucun voyage trouvé avec l'ID $id_voyage.");
}

$personnalisation = $_SESSION['personnalisation'][$id_voyage] ?? null;

if (!$personnalisation) {
    echo "<h2>Aucune personnalisation enregistrée.</h2>";
    echo "<a href='personnalisation_voyage.php?id=$id_voyage'>Retour à la personnalisation</a>";
    exit();
}

$totalPrix = 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Récapitulatif de <?php echo htmlspecialchars($voyage['titre']); ?></title>
   <link rel="stylesheet" href="projet.css/root.css">
   <link rel="stylesheet" href="projet.css/apart.css">
   <link rel="stylesheet" href="projet.css/voyages.css">
</head>
<body>
    <div class="navigation">
        <img src="image/logo.png" alt="logo du site web" width="100" class="image">
        <div class="menu">
        <ul>
            <li><a href="accueil.php" class="button">Accueil</a></li>
            <li><a href="présentation.php">Destination</a></li>

            <?php if(!isset($_SESSION["login"])): ?>
                <li><a href="connexion.php">Connexion</a></li>
            <?php endif; ?>

            <?php if(isset($_SESSION["login"])): ?>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            <?php endif; ?>
        </ul>
        </div>
    </div>

    <div class="voyages-details">
        <h1>✨ Récapitulatif de votre voyage : <?php echo htmlspecialchars($voyage['titre']); ?></h1>
        <img src="<?php echo htmlspecialchars($voyage['image']); ?>" alt="image du voyage" width="500" />
        <p><?php echo nl2br(htmlspecialchars($voyage['texte'])); ?></p>

        <h3>🗺️ Étapes sélectionnées :</h3>
        <ul>
            <?php foreach ($voyage['etapes'] as $index => $etape) {
                if (isset($personnalisation['etapes_selectionnees'][$index])) {
                    $nbPersonnes = intval($personnalisation['nb_personnes'][$index] ?? 1);
                    $prixEtape = (float) $etape['prix'] * (int) $nbPersonnes;
                    $totalPrix += $prixEtape;
            ?>
                <li>
                    <strong><?php echo htmlspecialchars($etape['titre']); ?></strong><br>
                    <p><?php echo htmlspecialchars($etape['description']); ?></p>
                    <strong>👥 Nombre de personnes :</strong> <?php echo $nbPersonnes; ?><br>
                    <strong>🏨 Hébergement :</strong> <?php echo htmlspecialchars($etape['hebergement']); ?><br>
                    <strong>🎭 Activités :</strong> <?php echo htmlspecialchars($etape['activites']); ?><br>
                    <strong>🚍 Transport :</strong> <?php echo htmlspecialchars($etape['transport']); ?><br>
                    <strong>💰 Prix total :</strong> <?php echo $prixEtape; ?> €<br><br>
                </li>
            <?php } } ?>
        </ul>

        <h3>💶 Montant total du voyage : <span><?php echo $totalPrix; ?> €</span></h3>

        <a href="personnalisation_voyage.php?id=<?php echo $id_voyage; ?>" class="btn">Modifier ma personnalisation</a>
        <a href="paiement.php?id=<?php echo $id_voyage; ?>" class="btn">Valider et payer</a>
        <br><br>
    </div>
</body>
</html>
