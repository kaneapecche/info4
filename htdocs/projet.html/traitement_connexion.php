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
            if (count($info) < 9) continue;

            if ($info[2] === $email && $info[7] === $password) { // Email + mot de passe OK
                $_SESSION["login"] = $info[6]; // Pseudo
                $_SESSION["email"] = $info[2];
                $_SESSION["tel"] = $info[3];
                $_SESSION["role"] = $info[8]; // <-- Ajout important

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

                // Redirection selon le rôle
                switch ($info[7]) {
                    case "Admin":
                        header("Location: admin.php");
                        break;
                    case "VIP":
                        header("Location: vip.php"); // remplace par la vraie page VIP
                        break;
                    default:
                        header("Location: profil.php"); // utilisateur standard
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
