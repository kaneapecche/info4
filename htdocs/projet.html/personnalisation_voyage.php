<?php
session_start();

$json = file_get_contents('donnees/voyages.json');
$voyages = json_decode($json, true);

if (!$voyages) {
    die("Erreur : Impossible de charger les données des voyages.");
}

$id_voyage = isset($_GET['id']) ? $_GET['id'] : null;

if ($id_voyage === null) {
    die("Erreur : Aucun ID reçu dans l'URL.");
}


$voyage = null;
foreach ($voyages as $v) {
    if (isset($v['id']) && $v['id'] == $id_voyage) {
        $voyage = $v;
        break;
    }
}

if (!$voyage) {
    die("Erreur : Aucun voyage trouvé avec l'ID $id_voyage.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['personnalisation'][$id_voyage] = $_POST;
    header("Location: resumer_voyage.php?id=$id_voyage");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title><?php echo htmlspecialchars($voyage['titre']); ?></title>
   <link rel="stylesheet" href="projet.css/root.css">
   <link rel="stylesheet" href="projet.css/apart.css">
   <link rel="stylesheet" href="projet.css/voyages.css">
   <link id="theme-css" rel="stylesheet" href="style-default.css">

   <script>
    document.addEventListener("DOMContentLoaded", function () {
        const idVoyage = new URLSearchParams(window.location.search).get('id');
        if (!idVoyage) return;

        
        const savedSelections = JSON.parse(localStorage.getItem("personnalisation_" + idVoyage)) || {};

        let total = 0;
        document.querySelectorAll("input[name^='etapes_selectionnees']").forEach((checkbox) => {
            let index = checkbox.dataset.index;
            if (savedSelections[index]) {
                checkbox.checked = true;
                let personnesInput = document.querySelector("input[name='nb_personnes[" + index + "]']");
                if (personnesInput) {
                    personnesInput.value = savedSelections[index].nbPersonnes;
                }
                total += parseFloat(checkbox.dataset.prix) * savedSelections[index].nbPersonnes;
            }
        });

        document.getElementById("totalPrix").innerText = total.toFixed(2) + " €";

        
        document.querySelectorAll("input[name^='etapes_selectionnees'], input[name^='nb_personnes']").forEach(input => {
            input.addEventListener("change", saveSelections);
        });
    });

    function saveSelections() {
        const idVoyage = new URLSearchParams(window.location.search).get('id');
        if (!idVoyage) return;

        let selections = {};
        let total = 0;

        document.querySelectorAll("input[name^='etapes_selectionnees']:checked").forEach((checkbox) => {
            let index = checkbox.dataset.index;
            let prixParPersonne = parseFloat(checkbox.dataset.prix);
            let personnesInput = document.querySelector("input[name='nb_personnes[" + index + "]']");
            let nbPersonnes = personnesInput ? parseInt(personnesInput.value) : 1;

            selections[index] = { nbPersonnes: nbPersonnes };
            total += prixParPersonne * nbPersonnes;
        });

       
        localStorage.setItem("personnalisation_" + idVoyage, JSON.stringify(selections));
        localStorage.setItem("totalPrix", total.toFixed(2));

        
        document.getElementById("totalPrix").innerText = total.toFixed(2) + " €";
    }
</script>
</body>
<select id="theme-switcher">
  <option value="style-default.css">Clair</option>
  <option value="style-dark.css">Sombre</option>
  <option value="style-accessible.css">Malvoyant</option>
</select>


    <div class="navigation">
        <img src="image/logo.png" alt="logo du site web" width="100" class="image">
        <div class="menu">
<ul>
            <li><a href="accueil.php">Accueil</a></li>
            <li><a href="présentation.php">Destination</a></li>

            <?php if(!isset($_SESSION["login"])): ?>
                <li><a href="connexion.php">Connexion</a></li>
         

           
                <li><a href="profil.php">Profil</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            <?php endif; ?>
        </ul>
        </div>
    </div>

    <div class="voyages-details">
        <h1><?php echo htmlspecialchars($voyage['titre']); ?></h1>
        <img src="<?php echo htmlspecialchars($voyage['image']); ?>" alt="image du voyage" width="500" />
        <p><?php echo nl2br(htmlspecialchars($voyage['texte'])); ?></p>

        <h3>🌍 Personnalisez votre voyage :</h3>
        <form method="POST">
            <ul>
            <?php if (!empty($voyage['etapes'])) { ?>
                <?php foreach ($voyage['etapes'] as $index => $etape) { ?>
                    <li>
                    <div class="etape-info">
                    <i class="fas fa-map-marker-alt"></i> <!-- Icône pour l'étape -->
                   
                        <input type="checkbox" name="etapes_selectionnees[<?php echo $index; ?>]" value="1" 
                               data-index="<?php echo $index; ?>" 
                               data-prix="<?php echo htmlspecialchars($etape['prix']); ?>" 
                               onchange="updateTotal()">
                        <strong>🗺️ Étape : <?php echo htmlspecialchars($etape['titre']); ?></strong><br>

                        <p><?php echo htmlspecialchars($etape['description']); ?></p>

                        <strong>👥 Nombre de personnes maximum :</strong> <?php echo htmlspecialchars($etape['nb_personnes']); ?><br>
                        <strong>🏨 Hébergement :</strong> <?php echo htmlspecialchars($etape['hebergement']); ?><br>
                        <strong>🎭 Activités :</strong> <?php echo htmlspecialchars($etape['activites']); ?><br>
                        <strong>🚍 Transport :</strong> <?php echo htmlspecialchars($etape['transport']); ?><br>

                        
                        <strong>👥 Nombre de personnes :</strong>
                        <input type="number" name="nb_personnes[<?php echo $index; ?>]" value="1" min="1" max="<?php echo htmlspecialchars($etape['nb_personnes']); ?>" onchange="updateTotal()"><br>

                        <strong>💰 Prix :</strong> <?php echo htmlspecialchars($etape['prix']); ?> € / par personne
                        <br><br>
                    </div>
                </li>
                <?php } ?>
            <?php } else { ?>
                <p>Aucune étape définie pour ce voyage.</p>
            <?php } ?>
            </ul>
            
            <h3>💶 Total estimé : <span id="totalPrix">0 €</span></h3>

            <button type="submit">✨ Voir le récapitulatif</button>

            <br><br>
        </form>
    </div>
       <script src="script_couleur.js"></script>

</body>
</html>
