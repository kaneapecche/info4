<?php


// Redirige si le fichier est ouvert directement sans les variables nécessaires
if (!isset($users_to_display) || !isset($page) || !isset($total_pages)) {
    header('Location: admin.php');// Redirection vers admin.php
    exit();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SereniTrip</title>
    <link rel="stylesheet" href="projet.css/root.css">
    <link rel="stylesheet" href="projet.css/apart.css">
    <link rel="stylesheet" href="projet.css/utilisateurs.css"> 
    <!-- Icônes Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
   
    <link id="theme-css" rel="stylesheet" href="projet.css/style-default.css">
</head>
<!-- Script de gestion de rôles utilisateur -->
<script src="admin.js"></script>

<body>
    <!-- Sélecteur de thème (clair / sombre / accessible) -->
<select id="theme-switcher">
  <option value="projet.css/style-default.css">Clair</option>
  <option value="projet.css/style-dark.css">Sombre</option>
  <option value="projet.css/style-accessible.css">Malvoyant</option>
</select>

<!-- Barre de navigation principale -->
    <div class="navigation">
        <img src="logo.png" alt="logo du site web" width="100" class="image">
        <div class="menu">
        <ul>
            <li><a href="accueil.php" class="button">Accueil</a></li>
            <li><a href="présentation.php">Destination</a></li>
            <!-- Affichage conditionnel si connecté ou non -->
            <?php if (!isset($_SESSION["login"])): ?>
                <li><a href="connexion.php">Connexion</a></li>
            <?php else: ?>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            <?php endif; ?>
        </ul>
        </div>
    </div>
<!-- Contenu principal : tableau des utilisateurs -->
    <div class="tab">
        <h1>Liste des Utilisateurs</h1>
        <table>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Adresse e-mail</th>
                <th>Numéro de téléphone</th>
                <th>Status</th>
                <th><i class="fa-solid fa-pen"></i></th>  <!-- Colonne d'action -->
                <th>Banir</th>
            </tr>
                <!-- Affichage dynamique de chaque utilisateur -->
            <?php foreach ($users_to_display as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user[0]) ?></td> <!-- Nom -->
                <td><?= htmlspecialchars($user[1]) ?></td> <!-- Prénom -->
                <td><?= htmlspecialchars($user[2]) ?></td> <!-- Email -->
                <td><?= htmlspecialchars($user[3]) ?></td> <!-- Téléphone -->
               
                  <!-- Cellule spéciale utilisée par JS pour mise à jour du rôle -->
                <td class="user-role" data-user-id="<?= htmlspecialchars($user[2]) ?>">
    <?= htmlspecialchars($user[8]) ?>
</td>
  <!-- Bouton pour changer le rôle (activé par JS) -->
<td>
    <button class="action-btn" data-email="<?= htmlspecialchars($user[2]) ?>" title="Modifier">
        <i class="fa-solid fa-user-pen"></i>
    </button>
</td>
<td class="ban-status" data-user-id="<?= htmlspecialchars($user[2]) ?>">
        <?= ($user[11] ?? 'non') === 'oui' ? '❌' : '' ?>
    </td>
    <td>
        <button class="ban-btn" data-email="<?= htmlspecialchars($user[2]) ?>" title="Bannir/dé-bannir">
            <i class="fa-solid fa-ban"></i>
        </button>
    </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="admin.php?page=<?= $page - 1 ?>" class="button">⬅️ Page précédente</a>
            <?php endif; ?>

            <?php if ($page < $total_pages): ?>
                <a href="admin.php?page=<?= $page + 1 ?>" class="button">➡️ Page suivante</a>
            <?php endif; ?>
        </div>
    </div>
    <!-- Script de gestion du thème (changer les styles) -->
   <script src="script_couleur.js"></script>
   <!-- Script JS : changement de rôle en AJAX -->
   <script>
document.addEventListener("DOMContentLoaded", () => {
    // Sélectionne tous les boutons pour changer le rôle
    document.querySelectorAll(".action-btn").forEach(button => {
        button.addEventListener("click", () => {
            const email = button.dataset.email;// Récupère l'e-mail de l'utilisateur
            const roleCell = document.querySelector(`.user-role[data-user-id="${email}"]`);
            const currentRole = roleCell.textContent.trim();// Rôle actuel (Admin/User)
            const newRole = currentRole === "Admin" ? "User" : "Admin";// Inversion
            // Animation : spinner pendant le chargement
            const icon = button.querySelector("i");
            const originalIcon = icon.className;
            icon.className = "fa fa-spinner fa-spin";
            button.disabled = true;
             // Envoie la nouvelle valeur au serveur en AJAX (JSON)
            fetch("admin_update_role.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ email: email, role: newRole })
            })
            .then(response => response.json())
            .then(data => {
                // Si succès : mise à jour du texte dans le tableau
                if (data.success) {
                    roleCell.textContent = newRole;
                } else {
                    alert("Erreur : " + data.message);
                }
            })
            .catch(error => {
                alert("Erreur serveur : " + error.message);
            })
            .finally(() => {
                 // Réinitialise l'icône et réactive le bouton
                icon.className = originalIcon;
                button.disabled = false;
            });
        });
    });
});
    // Script pour bannir/débannir
    document.querySelectorAll(".ban-btn").forEach(button => {
        button.addEventListener("click", () => {
            const email = button.dataset.email;
            const banCell = document.querySelector(`.ban-status[data-user-id="${email}"]`);
            const isBanned = banCell.textContent.trim() === "❌";
            const newBanStatus = isBanned ? "non" : "oui";

            const icon = button.querySelector("i");
            const originalIcon = icon.className;
            icon.className = "fa fa-spinner fa-spin";
            button.disabled = true;

            fetch("admin_ban_user.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ email: email, ban: newBanStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    banCell.textContent = newBanStatus === "oui" ? "❌" : "";
                } else {
                    alert("Erreur : " + data.message);
                }
            })
            .catch(error => {
                alert("Erreur serveur : " + error.message);
            })
            .finally(() => {
                icon.className = originalIcon;
                button.disabled = false;
            });
        });
    });
</script>


</body>
</html>
