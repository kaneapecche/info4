<?php 
session_start(); 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SereniTrip - Admin</title>
    <link rel="stylesheet" href="projet.css/root.css">
    <link rel="stylesheet" href="projet.css/apart.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link id="theme-css" rel="stylesheet" href="style-default.css">

</head>
<body>
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
                <li><a href="présentation.php">Destination</a></li>

                <?php if(!isset($_SESSION["login"])): ?>
                    <li><a href="connexion.php">Connexion</a></li>
                <?php else: ?>
                    <li><a href="profil.php">Profil</a></li>
                    <li><a href="logout.php">Déconnexion</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <div class="tab">
        <table>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Adresse e-mail</th>
                <th>Numéro de téléphone</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php
            // Définir le chemin du fichier CSV
            $fichier_csv = "donnees/utilisateurs.csv";

            // Vérifier si le fichier existe
            if (file_exists($fichier_csv)) {
                // Ouvrir le fichier en mode lecture
                if (($handle = fopen($fichier_csv, "r")) !== FALSE) {
                    // Lire chaque ligne du fichier
                    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                        echo "<tr>
                                <td>{$data[0]}</td>
                                <td>{$data[1]}</td>
                                <td>{$data[2]}</td>
                                <td>{$data[3]}</td>
                                <td>{$data[4]}</td>
                                <td>
                                    <button class='action-btn' title='Modifier'>
                                        <i class='fa-solid fa-user-pen'></i>
                                    </button>
                                </td>
                              </tr>";
                    }
                    fclose($handle);
                } else {
                    echo "<tr><td colspan='6'>Erreur lors de l'ouverture du fichier.</td></tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Aucun utilisateur trouvé.</td></tr>";
            }
            ?>
        </table>
    </div>
     <script src="script_couleur.js"></script>
</body>
</html>
