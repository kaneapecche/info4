<?php

$json = file_get_contents('donnees/voyages.json');
$voyages = json_decode($json, true);

if (!$voyages) {
    die("Erreur : Impossible de charger les données des voyages.");
}

$id_voyage = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($id_voyage === null) {
    die(" Erreur : Aucun ID reçu dans l'URL.");
}

$voyage = null;
foreach ($voyages as $v) {
    if (isset($v['id']) && $v['id'] == $id_voyage) {
        $voyage = $v;
        break;
    }
}

if (!$voyage) {
    die(" Erreur : Aucun voyage trouvé avec l'ID $id_voyage.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title><?php echo htmlspecialchars($voyage['titre']); ?></title>
   <link rel="stylesheet" href="projet.css/root.css">
   <link rel="stylesheet" href="projet.css/apart.css">

   </head>
<body>
    <div class="navigation">
        <img src="image/logo.png" alt="logo du site web" width="100" class="image">
        <div class="menu">
            <ul>
                <li><a href="accueil.php">Accueil</a></li>
                <li><a href="présentation.php">Destination</a></li>
                <li><a href="connexion.php">Connexion</a></li>
                <li><a href="profil.php">Profil</a></li>
            </ul>
        </div>
    </div>

   
    <div class="voyages-details">
        <h1><?php echo htmlspecialchars($voyage['titre']); ?></h1>
        <img src="<?php echo htmlspecialchars($voyage['image']); ?>" alt="image du voyage" width="500" />
        <p><?php echo nl2br(htmlspecialchars($voyage['texte'])); ?></p>

        <h3>🌍 Étapes du voyage :</h3>
        <ul>
            <?php if (!empty($voyage['etapes'])) { ?>
                <?php foreach ($voyage['etapes'] as $etape) { ?>
                    <li>
                        <strong>🗺️ Étape :</strong> <?php echo htmlspecialchars($etape['titre']); ?><br>
                        <strong>📜 Description :</strong> <?php echo htmlspecialchars($etape['description']); ?><br>
                        <strong>🏨 Hébergement :</strong> <?php echo htmlspecialchars($etape['hebergement']); ?><br>
                        <strong>🎭 Activités :</strong> <?php echo htmlspecialchars($etape['activites']); ?><br>
                        <strong>🍽️ Restauration :</strong> <?php echo htmlspecialchars($etape['restauration']); ?><br>
                        <strong>🚍 Transport :</strong> <?php echo htmlspecialchars($etape['transport']); ?><br>
                        <strong>👥 Nombre de personnes maximum :</strong> <?php echo htmlspecialchars($etape['nb_personnes']); ?><br>
                        <strong>💰 Prix :</strong> <?php echo htmlspecialchars($etape['prix']); ?><br>
                        
                    </li>
                <?php } ?>
            <?php } else { ?>
                <p>Aucune étape définie pour ce voyage.</p>
            <?php } ?>
        </ul>

        <a href="personnalisation_voyage.php?id=<?php echo $id_voyage; ?>">✨ Personnaliser mon voyage</a>
    </div>

</body>
</html>


           
