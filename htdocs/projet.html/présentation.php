<?php
$json = file_get_contents('donnees/voyages.json');
$voyages = json_decode($json, true);
$type_voyage = isset($_GET['type-voyage']) ? $_GET['type-voyage'] : 'tout'; // 'tout' par défaut

if ($type_voyage != 'tout') {
    $voyages = array_filter($voyages, function($voyage) use ($type_voyage) {
        return strpos(strtolower($voyage['titre']), strtolower($type_voyage)) !== false;
    });
}

$voyages_par_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $voyages_par_page;
$voyages_limites = array_slice($voyages, $offset, $voyages_par_page);


$total_voyages = count($voyages);
$total_pages = ceil($total_voyages / $voyages_par_page);


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>SereniTrip</title>
   <link rel="stylesheet" href="projet.css/root.css">
   <link rel="stylesheet" href="projet.css/login.css">
</head>
<body>
    <div class="navigation">
        <img src="image/logo.png" alt="logo du site web" width="100" class="image">
        <div class="menu">
    <ul class="boutton">
        <li><a href="accueil.php">Accueil</a></li>
        <li><a href="présentation.php">Destination</a></li>
        <li><a href="connexion.php">Connexion</a></li>
        <li><a href="profil.php">Profil</a></li>
     </ul>

   <h1><i>SereniTrip</i></h1>Le voyage qui vous ressource.🧘‍♀️
   <form action="/recherche" method="get">
    <input type="search" name="recherche" placeholder="Rechercher...">
    <button type="submit">Recherche</button>
</form><br/>

<div class="filter-section">
    
    <div>
        <label for="date-arrivee">Date d'arrivée</label>
        <input type="date" id="date-arrivee">
    </div>
    
    <div>
        <label for="date-depart">Date de départ</label>
        <input type="date" id="date-depart">
    </div>
    
    <div>
        <label for="type-voyage">Type de voyage</label>
        <select id="type-voyage">
          <option value="tout">Tout</option>
          <option value="bain-thermal">Bain thermal</option>
          <option value="spa">Spa</option>
          <option value="thalassotherapie">Thalassothérapie</option>
          <option value="yoga">Yoga</option>
          <option value="hammam">Hammam</option>
          <option value="jacuzzi">Jacuzzi</option>
        </select>
      </div>
</div>

<div class="contained">
        <?php if (!empty($voyages_limites)) { ?>
            <?php foreach ($voyages_limites as $index => $valeur) { ?>  
                <div class="container">
                    <h4><?php echo htmlspecialchars($valeur['titre']); ?>– <?php echo htmlspecialchars($valeur['prix']); ?> Tout Compris ! ✨ </h4>
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
<br><br>
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
