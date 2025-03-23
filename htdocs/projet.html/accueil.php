
<?php
$json = file_get_contents('donnees/voyages.json');
$voyages = json_decode($json, true);

if (!$voyages) {
    die("Erreur : Impossible de charger les données des voyages.");
}

// Sélectionne 3 voyages pour la section "Voyages à la Une"
$voyagesAlaUne = array_slice($voyages, 0, 5);
?>
<!DOCTYPE html>
<html lang="en"></html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="projet.css/root.css">
<link rel="stylesheet" href="projet.css/login.css">
<title> SereniTrip </title>
<link rel="shortcut icon" href="image/logo.png" type="image/x-icon">

</head>
<body bgcolor="#b7acac " text="'white" link="black">

<div class="navigation">
   <img src="image/logo.png" alt="logo du site web" width="100" class="image">
   <div class="menu">
<ul>
   <li><a href="accueil.php">Accueil</a></li>
   <li><a href="présentation.php">Destination</a></li>
   <li><a href="connexion.php">Connexion</a></li>
   <li><a href="profil.php">Profil</a></li>
</ul>


<h1><i>Bienvenue à SereniTrip</i></h1>
<h4>Envie de voyager tout en prenant soin de vous ? SereniTrip vous accompagne dans la découverte de destinations ressourçantes, entre nature, détente et bien-être. Que vous rêviez d’une retraite yoga face à l’océan, d’un séjour spa en pleine montagne ou d’un voyage immersif loin du stress quotidien, nous avons sélectionné pour vous les meilleures expériences pour voyager en toute sérénité.</h4>


<h4>🌍 Destinations inspirantes – Des lieux paisibles pour se reconnecter à soi. <br>
   🧘‍♀️ Expériences bien-être – Yoga, méditation, spas et séjours détente. <br>
   🍃 Voyager autrement – Conseils pour un voyage éco-responsable et équilibré. <br>
  
   Prenez le temps, respirez, explorez. Votre voyage bien-être commence ici. 💙✨</h4>

   <div class="contained">
    <?php foreach ($voyagesAlaUne as $voyage) { ?>
        <<div class="voyage-card">
    <img src="<?php echo htmlspecialchars($voyage['image']); ?>" alt="Image de <?php echo htmlspecialchars($voyage['titre']); ?>" width="300">
    <h3><?php echo htmlspecialchars($voyage['titre']); ?></h3>
    
    <!-- Vérifier si la clé 'description' existe avant de l'afficher -->
    <p>
        <?php echo isset($voyage['description']) ? htmlspecialchars($voyage['description']):"description"; ?>
    </p>

    <a href="personnalisation_voyage.php?id=<?php echo $voyage['id']; ?>">🌍 Voir plus</a>
</div>

    <?php } ?>
   <ul class="center-list">
      <li><a href="présentation.php">Commencez votre aventure dès maintenant !</a></li>
   </ul>
   <h2>🌟 Voyages à la Une</h2>

</div>
</body>
</html>