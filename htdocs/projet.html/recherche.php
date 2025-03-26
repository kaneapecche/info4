<?php
// Charger les voyages depuis le fichier JSON
$json = file_get_contents('voyages.json');
$voyages = json_decode($json, true);

// Récupération des filtres soumis par l'utilisateur
$titre = $_GET['titre'] ?? '';
$date_arrivee = $_GET['date-arrivee'] ?? '';
$date_depart = $_GET['date-depart'] ?? '';
$options = isset($_GET['options']) ? $_GET['options'] : [];
$personnes_supplementaires = $_GET['personnes'] ?? '';
$type = $_GET['type'] ?? '';
// Filtrage des voyages
$resultats = [];

foreach ($voyages as $voyage) {
    // Filtrage par titre
    $matchTitre = ($titre === '' || stripos($voyage['titre'], $titre) !== false);

    // Filtrage par type
    $matchType = ($type === '' || (is_array($type) ? in_array($voyage['type'], $type) : stripos($voyage['type'], $type) !== false));

    // Ajouter le voyage aux résultats si les critères sont satisfaits
    if ($matchTitre && $matchType) {
        $resultats[] = $voyage;
    }
}



// Pagination
$voyages_par_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $voyages_par_page;
$voyages_limites = array_slice($resultats, $offset, $voyages_par_page);

$total_voyages = count($resultats);
$total_pages = ceil($total_voyages / $voyages_par_page);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>SereniTrip - Recherche</title>
   <link rel="stylesheet" href="root.css">
   <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="navigation">
        <img src="logo.png" alt="logo du site web" width="100" class="image">
        <div class="menu">
            <ul class="boutton">
                <li><a href="accueil.php">Accueil</a></li>
                <li><a href="presentation.php">Destination</a></li>
                <li><a href="connexion.php">Connexion</a></li>
                <li><a href="profil.php">Profil</a></li>
            </ul>

            
        </div>
        <h3>Résultats de recherche pour "<?= htmlspecialchars($titre) ?>"</h3>

    </div>

<h3>Résultats de recherche pour "<?= htmlspecialchars($titre) ?>"</h3>    
    <!-- Affichage des voyages filtrés avec pagination -->
    <div class="contained">
        <?php if (!empty($voyages_limites)) { ?>
            <?php foreach ($voyages_limites as $index => $valeur) { ?>  
                <div class="container">
                    <h4><?php echo htmlspecialchars($valeur['titre']); ?> – <?php echo htmlspecialchars($valeur['prix']); ?> Tout Compris ! ✨ </h4>
                    <p><?php echo htmlspecialchars($valeur['texte']); ?></p>
                    <span>
                        <a href="voyages_details.php?id=<?php echo $offset + $index; ?>">
                            <img src="<?php echo htmlspecialchars($valeur['image']); ?>" width="250" height="180" alt="<?php echo htmlspecialchars($valeur['titre']); ?>" />
                        </a>
                    </span>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>Aucun voyage disponible pour le moment.</p>
        <?php } ?>
    </div>
</body>
</html>
