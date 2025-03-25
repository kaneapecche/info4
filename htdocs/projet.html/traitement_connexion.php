<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = $_POST["email"] ?? "";
            $password = $_POST["password"] ?? "";
        
            if (empty($email) || empty($password)) {
                echo "Veuillez remplir tous les champs.";
                exit();
            }
        
            $file = "donnees/utilisateurs.csv";
            $userFound = false;
        
            if (file_exists($file)) {
                $fp = fopen($file, "r");
        
                while (($info = fgetcsv($fp, 10000, ';')) !== false) {
                    if (count($info) < 9) continue;
        
                    if ($info[2] === $email && $info[7] === $password) { // Vérification email + mot de passe
                        $_SESSION["login"] = $info[6]; // Pseudo
                        $_SESSION["email"] = $info[2];
                        $_SESSION["tel"] = $info[3];
        
                        // Mise à jour de la dernière connexion
                        $utilisateurs = file($file, FILE_IGNORE_NEW_LINES);
                        $fp_w = fopen($file, "w");
        
                        foreach ($utilisateurs as $ligne) {
                            $data = str_getcsv($ligne, ';');
        
                            if (count($data) >= 9 && $data[2] === $email) {
                                $data[9] = date("Y-m-d H:i:s"); // Dernière connexion
                            }
                            fputcsv($fp_w, $data, ';');
                        }
        
                        fclose($fp_w);
                        fclose($fp);
        
                        // Rediriger vers le profil
                        header("Location: profil.php");
                        exit();
                    }
                }
                fclose($fp);
            }
        
            echo "Email ou mot de passe incorrect.";
            exit();
        }
    ?>
</body>
</html>
