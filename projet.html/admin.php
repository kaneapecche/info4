<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SereniTrip</title>
    <link rel="stylesheet" href="projet.css/root.css">
    <link rel="stylesheet" href="projet.css/apart.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
    <div class="tab">
        <table>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Adresse e-mail</th>
                <th>Numéro de téléphone</th>
                <th>Status</th>
                <th>
                        <i class="fa-solid fa-pen"></i>
                </th>
            </tr>
            <tr>
                <td>Kane</td>
                <td>Codou</td>
                <td>jenesaisquoi@gmail.com</td>
                <td>0612345678</td>
                <td>VIP</td>
                <td>
                    <button class="action-btn" title="Modifier">
                        <i class="fa-solid fa-user-pen"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>Ketata</td>
                <td>Mejdoline</td>
                <td>jenesaistoujourspasquoi@gmail.com</td>
                <td>0698765432</td>
                <td>Admin</td>
                <td>
                    <button class="action-btn" title="Modifier">
                        <i class="fa-solid fa-user-pen"></i>
                    </button>
                  </td>
            </tr>
            <tr>
                <td>El Kharroubi</td>
                <td>Assia</td>
                <td>jenesaisencorequoi@gmail.com</td>
                <td>0613579086</td>
                <td>Utilisateur</td>
                <td>
                    <button class="action-btn" title="Modifier">
                        <i class="fa-solid fa-user-pen"></i>
                    </button>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
