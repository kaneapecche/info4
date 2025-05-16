<?php 
session_start(); 

if (!isset($_SESSION["email"])) {
    header("Location: connexion.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nouveau_nom = $_POST['nom'];
    $nouveau_prenom = $_POST['prenom'];
    $nouveau_email = $_POST['email'];
    $nouveau_telephone = $_POST['telephone'];
    $nouveau_birthday = $_POST['birthday'];
    $nouveau_genre = $_POST['genre'];
    $nouveau_password = $_POST['password'];

    $fichier = 'donnees/utilisateurs.csv';
    $temp_fichier = 'donnees/temp_utilisateurs.csv';
    $modifie = false;

    if (($handle = fopen($fichier, "r")) !== FALSE) {
        $temp_handle = fopen($temp_fichier, "w");

        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            if ($data[2] == $_SESSION['email']) {
                $data[0] = $nouveau_nom;
                $data[1] = $nouveau_prenom;
                $data[2] = $nouveau_email;
                $data[3] = $nouveau_telephone;
                $data[4] = $nouveau_genre;
                $data[5] = $nouveau_birthday;
                $data[7] = $nouveau_password;
                $modifie = true;
            }
            fputcsv($temp_handle, $data, ";");
        }

        fclose($handle);
        fclose($temp_handle);

        if ($modifie) {
            unlink($fichier);
            rename($temp_fichier, $fichier);
            $_SESSION['email'] = $nouveau_email;
        } else {
            unlink($temp_fichier);
        }

        header("Location: profil.php");
        exit();
    }
}

function getUserData($email) {
    $fichier = 'donnees/utilisateurs.csv';
    if (($handle = fopen($fichier, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            if ($data[2] == $email) {
                fclose($handle);
                return [
                    'nom' => $data[0],
                    'prenom' => $data[1],
                    'email' => $data[2],
                    'telephone' => $data[3],
                    'genre' => $data[4],
                    'date_naissance' => $data[5],
                    'mot_de_passe' => $data[7],
                    'role' => $data[8] ?? ''
                ];
            }
        }
        fclose($handle);
    }
    return null;
}

$user = getUserData($_SESSION['email']);
if (!$user) {
    echo "Utilisateur non trouvé.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <title>Profil - SereniTrip</title>
   <link rel="stylesheet" href="projet.css/root.css">
   <link rel="stylesheet" href="projet.css/apart.css">
   <style>
       .button { margin-left: 10px; }
   </style>
</head>
<body>
    <div class="navigation">
        <img src="image/logo.png" alt="logo du site web" width="100" class="image">
        <div class="menu">
            <ul>
                <li><a href="accueil.php" class="button">Accueil</a></li>
                <li><a href="presentation.php">Destination</a></li>
                <?php if (!isset($_SESSION["email"])): ?>
                    <li><a href="connexion.php">Connexion</a></li>
                <?php else: ?>
                    <li><a href="profil.php">Profil</a></li>
                    <li><a href="logout.php">Déconnexion</a></li>
                    <?php if ($user['role'] === "admin"): ?>
                        <li><a href="admin.php">Admin</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <br>

    <div class="container">
        <fieldset class="center-form">
            <legend>Profil</legend>
            <form id="profil-form">
                <label for="nom">Nom:</label>
                <input class="fill" type="text" id="nom" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" disabled>
                <button type="button" onclick="enableEdit('nom')">✏️</button><br/>

                <label for="prenom">Prénom:</label>
                <input class="fill" type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" disabled>
                <button type="button" onclick="enableEdit('prenom')">✏️</button><br/>

                <label for="email">Email:</label>
                <input class="fill" type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" disabled>
                <button type="button" onclick="enableEdit('email')">✏️</button><br/>

                <label for="telephone">Téléphone:</label>
                <input class="fill" type="tel" id="telephone" name="telephone" value="<?= htmlspecialchars($user['telephone']) ?>" disabled>
                <button type="button" onclick="enableEdit('telephone')">✏️</button><br/>

                <label for="birthday">Date de naissance:</label>
                <input type="date" id="birthday" name="birthday" value="<?= htmlspecialchars($user['date_naissance']) ?>" disabled>
                <button type="button" onclick="enableEdit('birthday')">✏️</button><br/>

                <label>Genre:</label><br>
                <input type="radio" id="femme" name="genre" value="femme" <?= $user['genre'] == 'femme' ? 'checked' : '' ?> disabled> Femme
                <input type="radio" id="homme" name="genre" value="homme" <?= $user['genre'] == 'homme' ? 'checked' : '' ?> disabled> Homme
                <button type="button" onclick="enableEdit('genre')">✏️</button><br/>

                <label for="password">Mot de passe:</label>
                <input class="fill" type="password" id="password" name="password" value="<?= htmlspecialchars($user['mot_de_passe']) ?>" disabled>
                <button type="button" onclick="enableEdit('password')">✏️</button><br/><br/>

                <div id="save-buttons" style="display: none;">
        <button type="submit" class="button">Enregistrer</button>
        <button type="button" onclick="cancelEdit()">Annuler</button>
        <button type="button" onclick="resetForm()">Réinitialiser</button>
    </div>
            </form>
        </fieldset>
    </div>

    <script>
    let originalValues = {};

    function enableEdit(id) {
        const input = document.getElementById(id);
        if (input) {
            originalValues[id] = input.value;
            input.disabled = false;
        } else if (id === "genre") {
            document.querySelectorAll('input[name="genre"]').forEach(radio => {
                originalValues['genre'] = document.querySelector('input[name="genre"]:checked')?.value;
                radio.disabled = false;
            });
        }
        document.getElementById("save-buttons").style.display = "block";
    }

    function cancelEdit() {
        for (let id in originalValues) {
            const input = document.getElementById(id);
            if (input) {
                input.value = originalValues[id];
                input.disabled = true;
            } else if (id === "genre") {
                document.querySelectorAll('input[name="genre"]').forEach(radio => {
                    radio.disabled = true;
                    radio.checked = (radio.value === originalValues['genre']);
                });
            }
        }
        originalValues = {};
        document.getElementById("save-buttons").style.display = "none";
    }

    function resetForm() {
        document.querySelector("form").reset();
        document.querySelectorAll("input").forEach(input => input.disabled = false);
        document.getElementById("save-buttons").style.display = "block";
    }

    // 💡 Partie AJAX (Fetch API)
    document.getElementById('profil-form').addEventListener('submit', async function (e) {
    e.preventDefault();

    // Activer tous les champs désactivés temporairement pour les inclure dans FormData
    const disabledFields = document.querySelectorAll('#profil-form input:disabled');
    disabledFields.forEach(field => field.disabled = false);

    const formData = new FormData(this);

    try {
        const response = await fetch('modifier_profil.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            alert("Modification réussie !");
            location.reload();
        } else {
            alert("Erreur : " + result.message);
            cancelEdit();
        }

    } catch (error) {
        console.error('Erreur lors de l’envoi :', error);
        alert("Erreur réseau.");
        cancelEdit();
    } finally {
        // Remettre en disabled les champs non modifiés (optionnel)
        disabledFields.forEach(field => field.disabled = true);
    }
});

</script>

</body>
</html>
