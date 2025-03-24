<?php
// Charger les voyages depuis le fichier JSON
$json = file_get_contents('voyages.json');
$voyages = json_decode($json, true);

// Récupération des filtres soumis par l'utilisateur
$titre = $_GET['titre'] ?? '';
$date_arrivee = $_GET['date-arrivee'] ?? '';
$date_depart = $_GET['date-depart'] ?? '';
$position = $_GET['position'] ?? '';
$options = isset($_GET['options']) ? $_GET['options'] : [];
$personnes_supplementaires = $_GET['personnes'] ?? '';

// Filtrage des voyages
$resultats = [];
foreach ($voyages as $voyage) {
    if (($titre === '' || stripos($voyage['titre'], $titre) !== false) &&
        ($position === '' || stripos($voyage['position'], $position) !== false) &&
        ($date_arrivee === '' || $voyage['date_arrivee'] >= $date_arrivee) &&
        ($date_depart === '' || $voyage['date_depart'] <= $date_depart) &&
        (empty($options) || !array_diff($options, $voyage['options'])) && 
        ($personnes_supplementaires === '' || $voyage['personnes'] >= $personnes_supplementaires)) {
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
   <title>SereniTrip</title>
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
    </div>

    <h1><i>SereniTrip</i></h1>
    <p>Le voyage qui vous ressource.🧘‍♀️</p>

    <!-- Formulaire de filtrage -->
    <form action="" method="get">
        <input type="text" name="titre" placeholder="Titre du voyage" value="<?= htmlspecialchars($titre) ?>"><br>
        <label for="date-arrivee">Date d'arrivée</label>
        <input type="date" name="date-arrivee" value="<?= htmlspecialchars($date_arrivee) ?>">
        <label for="date-depart">Date de départ</label>
        <input type="date" name="date-depart" value="<?= htmlspecialchars($date_depart) ?>">
        <input type="text" name="position" placeholder="Position géographique" value="<?= htmlspecialchars($position) ?>"><br>
        <div>
            <label for="options">Type de voyage</label>
            <select id="options" name="options[]">
                <option value="Bain" <?= in_array('Bain', $options) ? 'selected' : '' ?>>Bain thermal</option>
                <option value="Massage" <?= in_array('Massage', $options) ? 'selected' : '' ?>>Massage</option>
                <option value="Relaxation" <?= in_array('Relaxation', $options) ? 'selected' : '' ?>>Relaxation</option>
                <option value="Yoga" <?= in_array('Yoga', $options) ? 'selected' : '' ?>>Yoga</option>
                <option value="Soins du corps" <?= in_array('Soins du corps', $options) ? 'selected' : '' ?>>Soins du corps</option>
                <option value="Jacuzzi" <?= in_array('Jacuzzi', $options) ? 'selected' : '' ?>>Jacuzzi</option>
            </select>
        </div><br>
        <input type="number" name="personnes" placeholder="Personnes supplémentaires" value="<?= htmlspecialchars($personnes_supplementaires) ?>"><br><br>
        <button type="submit">Filtrer</button>
    </form>

    <!-- Affichage des voyages filtrés avec pagination -->
<div class="contained">
    <?php if (!empty($voyages_limites)): ?>
        <div class="voyages-container">
            <?php foreach ($voyages_limites as $voyage): ?>
                <div class="container">
                    <h4><?= htmlspecialchars($voyage['titre']); ?> – <?= htmlspecialchars($voyage['prix']); ?> Tout Compris ! ✨</h4>
                    <p><?= htmlspecialchars($voyage['texte']); ?></p>
                    <img src="<?= htmlspecialchars($voyage['image']); ?>" width="250" height="180" alt="<?= htmlspecialchars($voyage['titre']); ?>">

                    <!-- Affichage des étapes -->
                    <?php foreach ($voyage['etapes'] as $etape): ?>
                        <div class="etape">
                            <h5><?= htmlspecialchars($etape['titre']); ?></h5>
                            <p><strong>Description:</strong> <?= htmlspecialchars($etape['description']); ?></p>
                            <p><strong>Hébergement:</strong> <?= htmlspecialchars($etape['hebergement']); ?></p>
                            <p><strong>Restauration:</strong> <?= htmlspecialchars($etape['restauration']); ?></p>
                            <p><strong>Activités:</strong> <?= htmlspecialchars($etape['activites']); ?></p>
                            <p><strong>Transport:</strong> <?= htmlspecialchars($etape['transport']); ?></p>
                            <p><strong>Nombre de personnes:</strong> <?= htmlspecialchars($etape['nb_personnes']); ?></p>
                            <p><strong>Prix:</strong> <?= htmlspecialchars($etape['prix']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Aucun voyage trouvé.</p>
    <?php endif; ?>
</div>


    <!-- Pagination -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1; ?>" class="pagination-arrow">« Précédent</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?= $i; ?>" class="pagination-link <?= $i == $page ? 'active' : ''; ?>"><?= $i; ?></a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?= $page + 1; ?>" class="pagination-arrow">Suivant »</a>
        <?php endif; ?>
    </div>
</body>
</html>
