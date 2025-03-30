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

// Filtrage des voyages
$resultats = [];
foreach ($voyages as $voyage) {
    if (($titre === '' || stripos($voyage['titre'], $titre) !== false) &&
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
            
            </form><br/>
        </div>
    </div>
            <h1><i>SereniTrip</i></h1>Touver le voyage qui vous ressource.🧘‍♀️
            
    <!-- Formulaire de filtrage -->
    <form action="recherche.php" method="get">
        <input type="text" name="titre" placeholder="Titre du voyage" value="<?= htmlspecialchars($titre) ?>"><br>
        <label for="date-arrivee">Date d'arrivée</label>
        <input type="date" name="date-arrivee" value="<?= htmlspecialchars($date_arrivee) ?>">
        <label for="date-depart">Date de départ</label>
        <input type="date" name="date-depart" value="<?= htmlspecialchars($date_depart) ?>"><br><br>
        <div>
            <label for="options">Type de voyage</label>
            <select id="options" name="type[]">
                <option value="Bain" <?= in_array('Bain', $options) ? 'selected' : '' ?>>Bain</option>
                <option value="Massage" <?= in_array('Massage', $options) ? 'selected' : '' ?>>Massage</option>
                <option value="Relaxation" <?= in_array('Relaxation', $options) ? 'selected' : '' ?>>Relaxation</option>
                <option value="Yoga" <?= in_array('Yoga', $options) ? 'selected' : '' ?>>Yoga</option>
                <option value="Evasion" <?= in_array('Evasion', $options) ? 'selected' : '' ?>>Evasion</option>
                <option value="Jacuzzi" <?= in_array('Jacuzzi', $options) ? 'selected' : '' ?>>Jacuzzi</option>
                <option value="Plages" <?= in_array('Plages', $options) ? 'selected' : '' ?>>Plages</option>
                <option value="Retraite" <?= in_array('Retraite', $options) ? 'selected' : '' ?>>Retraite</option>
                <option value="Flottaison" <?= in_array('Flottaison', $options) ? 'selected' : '' ?>>Flottaison</option>
                <option value="Sauna" <?= in_array('Sauna', $options) ? 'selected' : '' ?>>Sauna</option>
                <option value="Hammam" <?= in_array('Hammam', $options) ? 'selected' : '' ?>>Hammam</option>
                <option value="thalassothérapie" <?= in_array('thalassothérapie', $options) ? 'selected' : '' ?>>thalassothérapie</option>
            </select>
        </div><br>
        <input type="number" name="personnes" placeholder="Personnes supplémentaires" value="<?= htmlspecialchars($personnes_supplementaires) ?>"><br><br>
        <button type="submit">Filtrer</button>
    </form>

    <!-- Affichage des voyages filtrés avec pagination -->
    <div class="contained">
        <?php if (!empty($voyages_limites)) { ?>
            <?php foreach ($voyages_limites as $index => $valeur) { ?>  
                <div class="container">
                    <h4><?php echo htmlspecialchars($valeur['titre']); ?>– <?php echo htmlspecialchars($valeur['prix']); ?> Tout Compris ! ✨ </h4>
                    <p><?php echo htmlspecialchars($valeur['texte']); ?></p>
                    <p><?php echo htmlspecialchars($valeur['type']); ?></p>
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
<br><br>


    <!-- Pagination -->
    <div class="pagination">
       
        <?php if ($page > 1) { ?>
            <a href="?page=<?php echo $page - 1; ?>" class="pagination-arrow">« Précédent</a>
        <?php } ?>

       
         <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
             <a href="?page=<?php echo $i; ?>" class="pagination-link <?php echo $i == $page ? 'active' : ''; ?>">
                 <?php echo $i; ?>
            </a>
        <?php } ?>

      
        <?php if ($page < $total_pages) { ?>
             <a href="?page=<?php echo $page + 1; ?>" class="pagination-arrow">Suivant »</a>
         <?php } ?>
    </div>
<br><br>
</body>
</html>

