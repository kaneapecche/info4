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
    session_unset(); // Supprime toutes les variables de session
    session_destroy(); // Détruit la session
    
    header("Location: connexion.php"); // Redirige vers la page de connexion
    exit();
    ?>
</body>
</html>
