<?php
session_start(); // <-- indispensable

// Charger les voyages depuis le fichier JSON
$json = file_get_contents('donnees/voyages.json');
$voyages = json_decode($json, true);

// Récupération des filtres soumis par l'utilisateur
$titre = $_GET['titre'] ?? '';
$date_arrivee = $_GET['date-arrivee'] ?? '';
$date_depart = $_GET['date-depart'] ?? '';
$options = isset($_GET['type']) ? $_GET['type'] : []; // Assurer que c'est un tableau même s'il est vide
$personnes_supplementaires = $_GET['personnes'] ?? '';

// Filtrage des voyages
$resultats = [];
foreach ($voyages as $voyage) {
    if (($titre === '' || stripos($voyage['titre'], $titre) !== false) &&
        ($date_arrivee === '' || $voyage['date_arrivee'] >= $date_arrivee) &&
        ($date_depart === '' || $voyage['date_depart'] <= $date_depart) &&
        (empty($options) || in_array($voyage['type'], $options)) && 
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
   <link rel="stylesheet" href="projet.css/root.css">
   <link rel="stylesheet" href="projet.css/login.css">
   <link rel="stylesheet" href="projet.css/profil.css">
   <link id="theme-css" rel="stylesheet" href="projet.css/style-default.css">
</head>
<body>
<select id="theme-switcher">
  <option value="projet.css/style-default.css">Clair</option>
  <option value="projet.css/style-dark.css">Sombre</option>
  <option value="projet.css/style-accessible.css">Malvoyant</option>
</select>
    <div class="navigation">
        <img src="image/logo.png" alt="logo du site web" width="100" class="image">
        <div class="menu">
            <ul class="boutton">
                <li><a href="accueil.php">Accueil</a></li>
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
        <input type="text" name="titre" placeholder="Titre du voyage" value="<?= htmlspecialchars($titre) ?>">
        <div>
        <div>
        <label for="options">Type de voyage :</label>
        <select id="options" name="type[]">
            <!-- Les options seront ajoutées dynamiquement via le script JavaScript -->
        </select>
    </div><br> 
        <input type="number" name="personnes" placeholder="Personnes supplémentaires" value="<?= htmlspecialchars($personnes_supplementaires) ?>"><br>
       <br>
    
</div>
        <button type="submit">Filtrer</button>
    </form>

    <!-- Affichage des voyages filtrés avec pagination -->
    <div class="accueil">
        <?php if (!empty($voyages_limites)) { ?>
            <?php foreach ($voyages_limites as $index => $valeur) { ?>  
                <div class="accueil-card">
                    <h4><?php echo htmlspecialchars($valeur['titre']); ?>– <?php echo htmlspecialchars($valeur['prix']); ?> Tout Compris ! ✨ </h4>
                    <p><?php echo htmlspecialchars($valeur['texte']); ?></p><br>
                    <p><?php echo htmlspecialchars($valeur['type']); ?></p><br>
                    <br>
                    <span>
                       <a href="voyages_details.php?id=<?php echo $offset + $index; ?>">
                       <img src="<?php echo htmlspecialchars($valeur['image']); ?>" width="250" height="180" />
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

<script src="script_couleur.js"></script>  


<script>
    fetch('voyages.json')
    .then(response => response.json())
    .then(data => {
        const optionsSelect = document.getElementById('options');
        const typesVoyages = new Set(); // Utilise un Set pour éliminer les doublons

        // Parcours chaque voyage et ajoute son type dans le Set
        data.forEach(voyage => {
            console.log("TYPE:", voyage.type);  // Vérifie que le type est bien récupéré
            typesVoyages.add(voyage.type);
        });

        // Vide la liste des options existantes pour la mettre à jour
        optionsSelect.innerHTML = '';

        // Ajouter une option "Tous" en premier
        const optionTous = document.createElement('option');
        optionTous.value = '';
        optionTous.textContent = 'Tous';
        optionsSelect.appendChild(optionTous);

        // Ajouter les types de voyages au select
        typesVoyages.forEach(type => {
            const optionElement = document.createElement('option');
            optionElement.value = type;
            optionElement.textContent = type;
            optionsSelect.appendChild(optionElement);
        });
    })
    .catch(error => {
        console.error('Erreur de chargement des données JSON:', error);
    });

</script>
</body>
</html>
