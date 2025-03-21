<?php
$voyages = [
    ["titre" => "Bain thermal", "position" => "Paris", "date_arrivee" => "2025-04-10", "date_depart" => "2025-04-15", "options" => ["Bain", "Spa"], "personnes" => 2, "image" => "bain_thermal.jpg", "description" => "Relaxez-vous tout en ayant une belle vue"],
    ["titre" => "Spa", "position" => "Nice", "date_arrivee" => "2025-05-01", "date_depart" => "2025-05-07", "options" => ["Massage", "Relaxation"], "personnes" => 1, "image" => "spa.jpg", "description" => "Le rendez-vous du bien-être"],
    ["titre" => "Thalassothérapie", "position" => "Marseille", "date_arrivee" => "2025-06-10", "date_depart" => "2025-06-17", "options" => ["Mer", "Soins du corps"], "personnes" => 3, "image" => "thalaso.jpg", "description" => "Un bain de mer pour le corps et l'esprit"],
    ["titre" => "Yoga", "position" => "Lyon", "date_arrivee" => "2025-07-15", "date_depart" => "2025-07-22", "options" => ["Yoga", "Méditation"], "personnes" => 1, "image" => "yoga.jpg", "description" => "Profitez d'un voyage intérieur à chaque posture"],
    ["titre" => "Hammam", "position" => "Bordeaux", "date_arrivee" => "2025-08-05", "date_depart" => "2025-08-12", "options" => ["Hammam", "Relaxation"], "personnes" => 2, "image" => "hammam.jpg", "description" => "Un cocon pour rêver éveillé"],
    ["titre" => "Jacuzzi", "position" => "Toulouse", "date_arrivee" => "2025-09-10", "date_depart" => "2025-09-17", "options" => ["Jacuzzi", "Détente"], "personnes" => 1, "image" => "jacuzzi.jpg", "description" => "Plongez dans les bulles du bonheur"]
];

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

    <!-- Affichage des voyages filtrés -->
    <div class="contained">
        <?php if (!empty($resultats)): ?>
            <div class="voyages-container">
                <?php foreach ($resultats as $voyage): ?>
                    <div class="container">
                        <h4><?= htmlspecialchars($voyage['titre']); ?></h4>
                        <p><?= htmlspecialchars($voyage['description']); ?><p>
                        <img src="<?= htmlspecialchars($voyage['image']); ?>" width="250" height="180" alt="<?= htmlspecialchars($voyage['titre']); ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucun voyage trouvé.</p>
        <?php endif; ?>
    </div>
</body>
</html>

