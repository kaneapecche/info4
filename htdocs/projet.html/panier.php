<?php
session_start();

$json = file_get_contents('donnees/voyages.json');
$voyages = json_decode($json, true);

$panier = $_SESSION['panier'] ?? [];
$personnalisations = $_SESSION['personnalisation_panier'] ?? [];
$prix_total_general = 0;

if (empty($panier)) {
    echo "<h2>🛒 Votre panier est vide.</h2>";
    echo "<a href='présentation.php'>Retour aux destinations</a>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>🧳 Mon Panier</title>
  <link rel="stylesheet" href="projet.css/root.css">
  <link rel="stylesheet" href="projet.css/apart.css">
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
<ul>
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
        </div>
    </div>
<h1>🧳 Mon Panier</h1>

<?php
foreach ($panier as $id) {
    $voyage = null;

    foreach ($voyages as $v) {
        if ($v['id'] == $id) {
            $voyage = $v;
            break;
        }
    }

    if (!$voyage) continue;

    echo "<div class='voyage'>";
    echo "<h2>" . htmlspecialchars($voyage['titre']) . "</h2>";
    echo "<img src='" . htmlspecialchars($voyage['image']) . "' width='300'><br>";

    $total_personnalise = 0;

    if (isset($personnalisations[$id])) {
        $perso = $personnalisations[$id];

        echo "<h4>🗺️ Détails personnalisés :</h4><ul>";

        echo '<div class="accueil">';
        foreach ($voyage['etapes'] as $index => $etape) {
            if (isset($perso['etapes_selectionnees'][$index])) {
                $nb = $perso['nb_personnes'][$index] ?? 1;
                $prix = $etape['prix'] * $nb;
                $total_personnalise += $prix;
        
                echo '<div class="accueil-card">';
                echo "<strong>" . htmlspecialchars($etape['titre']) . "</strong><br>";
                echo "👥 Personnes : $nb<br>";
                echo "🏨 Hébergement : " . htmlspecialchars($etape['hebergement']) . "<br>";
                echo "🎭 Activités : " . htmlspecialchars($etape['activites']) . "<br>";
                echo "🚍 Transport : " . htmlspecialchars($etape['transport']) . "<br>";
                echo "💰 Prix : $prix €";
                echo '</div>';
            }
        }
        echo '</div>';
        
    }

        echo "</ul>";
}
    
    
    echo "<strong>💶 Prix total personnalisé : $total_personnalise €</strong><br>";
    echo "<a href='supprimer_panier.php?id=$id'>❌ Supprimer</a>";
    echo "</div><hr>";

    $prix_total_general += $total_personnalise;


echo "<h3>💸 Total général : $prix_total_general €</h3>";
echo "<a href='paiement.php?id=$id'>Valider et payer</a>";
?>
<script src="script_couleur.js"></script>

</body>
</html>
