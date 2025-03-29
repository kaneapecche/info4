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

// Gestion du filtre type (convertir en tableau si nécessaire)
$type = $_GET['type'] ?? [];
if (!is_array($type)) {
    $type = [$type];
}

// Filtrage des voyages
$resultats = [];
foreach ($voyages as $voyage) {
    $matchTitre = ($titre === '' || stripos($voyage['titre'], $titre) !== false);
    $matchDateArrivee = ($date_arrivee === '' || $voyage['date_arrivee'] >= $date_arrivee);
    $matchDateDepart = ($date_depart === '' || $voyage['date_depart'] <= $date_depart);
    $matchOptions = (empty($options) || !array_diff($options, $voyage['options']));
    $matchPersonnes = ($personnes_supplementaires === '' || $voyage['personnes'] >= $personnes_supplementaires);
    $matchType = (empty($type) || in_array($voyage['type'], $type));

    if ($matchTitre && $matchDateArrivee && $matchDateDepart && $matchOptions && $matchPersonnes && $matchType) {
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
   <link rel="stylesheet" href="voyage.css">
   <link rel="stylesheet" href="apart.css">
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
    </div>

    
    <!-- Affichage des voyages filtrés avec pagination -->
    <div class="contained">
        <?php if (!empty($voyages_limites)) { ?>
            <?php foreach ($voyages_limites as $index => $valeur) { ?>  
                <div class="container">
                    <h4><?= htmlspecialchars($valeur['titre']); ?> – <?= htmlspecialchars($valeur['prix']); ?> Tout Compris ! ✨</h4>
                    <?= htmlspecialchars($valeur['texte']); ?>
                    <p><strong>Type :</strong> <?= htmlspecialchars($valeur['type']); ?></p>
                    <span>
                        <a href="voyages_details.php?id=<?= $offset + $index; ?>">
                            <img src="<?= htmlspecialchars($valeur['image']); ?>" width="250" height="180" alt="<?= htmlspecialchars($valeur['titre']); ?>" />
                        </a>
                    </span>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>Aucun voyage disponible pour le moment.</p>
        <?php } ?>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($page > 1) { ?>
            <a href="?<?= http_build_query(array_merge($_GET, ["page" => $page - 1])) ?>" class="pagination-arrow">« Précédent</a>
        <?php } ?>

        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
            <a href="?<?= http_build_query(array_merge($_GET, ["page" => $i])) ?>" class="pagination-link <?= $i == $page ? 'active' : ''; ?>">
                <?= $i; ?>
            </a>
        <?php } ?>

        <?php if ($page < $total_pages) { ?>
            <a href="?<?= http_build_query(array_merge($_GET, ["page" => $page + 1])) ?>" class="pagination-arrow">Suivant »</a>
        <?php } ?>
    </div>

</body>
</html>
