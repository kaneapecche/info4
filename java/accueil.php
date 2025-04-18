<?php session_start(); ?>
   <?php
$json = file_get_contents('voyages.json');
$voyages = json_decode($json, true);

if (!$voyages) {
    die("Erreur : Impossible de charger les données des voyages.");
}


$voyagesAlaUne = array_slice($voyages, 0, 5);
?>
<!DOCTYPE html>
<html lang="en"></html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="root.css">
<link rel="stylesheet" href="login.css">
<link rel="stylesheet" href="profil.css">
<title> SereniTrip </title>
<link rel="shortcut icon" href="logo.png" type="image/x-icon">
<link id="theme-css" rel="stylesheet" href="style-default.css">
</head>
<body bgcolor="#b7acac " text="'white" link="black">
<select id="theme-switcher">
  <option value="style-default.css">Clair</option>
  <option value="style-dark.css">Sombre</option>
  <option value="style-accessible.css">Malvoyant</option>
</select>

<div class="navigation">
   <img src="logo.png" alt="logo du site web" width="100" class="image">
   <div class="menu">
<ul>
            <li><a href="accueil.php" class="button">Accueil</a></li>
            <li><a href="presentation.php">Destination</a></li>
            <?php if(!isset($_SESSION["login"])): ?>
                <li><a href="connexion.php">Connexion</a></li>
            <?php endif; ?>

            <?php if(isset($_SESSION["login"])): ?>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            <?php endif; ?>
        </ul>


<h1><i>Bienvenue à SereniTrip</i></h1>
<h4>Envie de voyager tout en prenant soin de vous ? SereniTrip vous accompagne dans la découverte de destinations ressourçantes, entre nature, détente et bien-être. Que vous rêviez d’une retraite yoga face à l’océan, d’un séjour spa en pleine montagne ou d’un voyage immersif loin du stress quotidien, nous avons sélectionné pour vous les meilleures expériences pour voyager en toute sérénité.</h4>


<h4>🌍 Destinations inspirantes – Des lieux paisibles pour se reconnecter à soi. <br>
   🧘‍♀️ Expériences bien-être – Yoga, méditation, spas et séjours détente. <br>
   🍃 Voyager autrement – Conseils pour un voyage éco-responsable et équilibré. <br>
  
   Prenez le temps, respirez, explorez. Votre voyage bien-être commence ici. 💙✨</h4>
   <h2>🌟 Voyages à la Une 🌟</h2>

<div class="accueil">
   <?php foreach ($voyagesAlaUne as $voyage) { ?>
      <div class="accueil-card">
         <img src="<?php echo htmlspecialchars($voyage['image']); ?>" alt="Image de <?php echo htmlspecialchars($voyage['titre']); ?>" width="300">
         <h3><?php echo htmlspecialchars($voyage['titre']); ?></h3>
         <p>
            <?php echo isset($voyage['description']) ? htmlspecialchars($voyage['description']) : "Aucune description disponible."; ?>
         </p>
         <a href="personnalisation_voyage.php?id=<?php echo $voyage['id']; ?>">🌍 Voir plus</a>
      </div>
   <?php } ?>
</div>

   
   <ul class="center-list">
      <li><a href="présentation.php">Commencez votre aventure dès maintenant !</a></li>
   </ul>
  
   <script src="script_couleur.js"></script>

</div>
</body>
</html>
