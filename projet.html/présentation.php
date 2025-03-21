<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>SereniTrip</title>
   <link rel="stylesheet" href="projet.css/root.css">
</head>
<body>

    <div class="navigation">
        <img src="image/logo.png" alt="logo du site web" width="100" class="image">
        <div class="menu">
        <ul>
            <li><a href="accueil.php">Accueil</a></li>
            <li><a href="présentation.php">Destination</a></li>
            <li><a href="connexion.php">Connexion</a></li>
        </ul>
        </div>
    </div>

   <h1><i>SereniTrip</i></h1>Le voyage qui vous ressource 🧘‍♀️
   <form action="/recherche" method="get">
      <input type="search" name="recherche" placeholder="Rechercher...">
      <button type="submit">Envoyer</button>
  </form>

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
    <div class="container">
        <h4>Voyage 1: Bain thermal </h4>
        <p>Relaxez-vous tout en ayant une belle vue</p>
        <img src="image/bain_thermal.jpg" width="250" height="180"/>
    </div>
    <div class="container">
        <h4>Voyage 2: Spa </h4>
        <p>Le rendez-vous du bien-être</p>
        <img src="image/spa.jpg" width="250" height="180"/>
    </div>
    <div class="container">
        <h4>Voyage 3: Thalassothérapie </h4>
        <p>Un bain de mer pour le corps et l'esprit</p>
        <img src="image/thalaso.jpg" width="250" height="180"/>
    </div>
    <div class="container">
        <h4>Voyage 4: Yoga </h4>
        <p>Profitez d'un voyage intérieur à chaque posture</p>
        <img src="image/yoga.jpg" width="250" height="180"/>
    </div>
    <div class="container">
        <h4>Voyage 5: Hammam </h4>
        <p>Un cocon pour rêver éveillé</p>
        <img src="image/hammam.jpg" width="250" height="180"/>
    </div>
        <div class="container">
        <h4>Voyage 6: Jacuzzi </h4>
        <p>Plongez dans les bulles du bonheur</p>
        <img src="image/jacuzzi.jpg" width="250" height="180"/>
    </div> 
</body>
</html>
