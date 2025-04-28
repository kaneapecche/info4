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
   
</head>
<body>

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

        foreach ($voyage['etapes'] as $index => $etape) {
            if (isset($perso['etapes_selectionnees'][$index])) {
                $nb = $perso['nb_personnes'][$index] ?? 1;
                $prix = $etape['prix'] * $nb;
                $total_personnalise += $prix;

                echo "<li><strong>" . htmlspecialchars($etape['titre']) . "</strong><br>";
                echo "👥 Personnes : $nb<br>";
                echo "🏨 Hébergement : " . htmlspecialchars($etape['hebergement']) . "<br>";
                echo "🎭 Activités : " . htmlspecialchars($etape['activites']) . "<br>";
                echo "🚍 Transport : " . htmlspecialchars($etape['transport']) . "<br>";
                echo "💰 Prix : $prix €</li><br>";
            }
        }

        echo "</ul>";
    }

    echo "<strong>💶 Prix total personnalisé : $total_personnalise €</strong><br>";
    echo "<a href='supprimer_panier.php?id=$id'>❌ Supprimer</a>";
    echo "</div><hr>";

    $prix_total_general += $total_personnalise;
}

echo "<h3>💸 Total général : $prix_total_general €</h3>";
echo "<a href='paiement.php'>Valider et payer</a>";
?>
</body>
</html>
