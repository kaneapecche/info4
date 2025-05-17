<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    if (empty($email) || empty($password)) {
        echo "Veuillez remplir tous les champs.";
        exit();
    }

    $file = "donnees/utilisateurs.csv";

    if (file_exists($file)) {
        $fp = fopen($file, "r");

        while (($info = fgetcsv($fp, 10000, ';')) !== false) {
            if (count($info) < 11) continue;

            if ($info[2] === $email && $info[7] === $password) {
                if (strtolower(trim($info[11])) === "oui") {
                    echo "⚠️ Votre compte a été banni. Vous ne pouvez pas accéder au site.";
                    fclose($fp);
                    exit();
                }

                $_SESSION["login"] = $info[6];
                $_SESSION["email"] = $info[2];
                $_SESSION["tel"] = $info[3];
                $_SESSION["role"] = $info[8];

                // Mise à jour de la dernière connexion
                $utilisateurs = file($file, FILE_IGNORE_NEW_LINES);
                $fp_w = fopen($file, "w");

                foreach ($utilisateurs as $ligne) {
                    $data = str_getcsv($ligne, ';');
                    if (count($data) >= 9 && $data[2] === $email) {
                        $data[9] = date("Y-m-d H:i:s");
                    }
                    fputcsv($fp_w, $data, ';');
                }

                fclose($fp_w);
                fclose($fp);

                // ✅ Redirection contextuelle si demandée
                if (isset($_GET['redirect']) && !empty($_GET['redirect'])) {
                    header("Location: " . $_GET['redirect']);
                    exit();
                }

                // Redirection selon le rôle
                switch ($info[7]) {
                    case "Admin":
                        header("Location: admin.php");
                        break;
                    case "VIP":
                        header("Location: vip.php");
                        break;
                    default:
                        header("Location: profil.php");
                        break;
                }
                exit();
            }
        }
        fclose($fp);
    }

    echo "Email ou mot de passe incorrect.";
    exit();
}
?>
