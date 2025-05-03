<?php


// Redirige si le fichier est ouvert directement
if (!isset($users_to_display) || !isset($page) || !isset($total_pages)) {
    header('Location: admin.php');
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
    <link rel="stylesheet" href="utilisateurs.css"> <!-- ton nouveau css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<script src="admin.js"></script>

<body>

    <div class="navigation">
        <img src="image/logo.png" alt="logo du site web" width="100" class="image">
        <div class="menu">
        <ul>
            <li><a href="accueil.php" class="button">Accueil</a></li>
            <li><a href="présentation.php">Destination</a></li>
            <?php if (!isset($_SESSION["login"])): ?>
                <li><a href="connexion.php">Connexion</a></li>
            <?php else: ?>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            <?php endif; ?>
        </ul>
        </div>
    </div>

    <div class="tab">
        <h1>Liste des Utilisateurs</h1>
        <table>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Adresse e-mail</th>
                <th>Numéro de téléphone</th>
                <th>Status</th>
                <th><i class="fa-solid fa-pen"></i></th>
            </tr>

            <?php foreach ($users_to_display as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user[0]) ?></td> <!-- Nom -->
                <td><?= htmlspecialchars($user[1]) ?></td> <!-- Prénom -->
                <td><?= htmlspecialchars($user[2]) ?></td> <!-- Email -->
                <td><?= htmlspecialchars($user[3]) ?></td> <!-- Téléphone -->
                <td><?= htmlspecialchars($user[7]) ?></td> <!-- Rôle -->
                <td class="user-role" data-user-id="<?= htmlspecialchars($user[2]) ?>">
    <?= htmlspecialchars($user[7]) ?>
</td>
<td>
    <button class="action-btn" data-email="<?= htmlspecialchars($user[2]) ?>" title="Modifier">
        <i class="fa-solid fa-user-pen"></i>
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

</body>
</html>
