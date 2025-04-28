<?php
session_start();

$id = $_GET['id'] ?? null;
if (!$id) die("ID manquant.");

// Supprimer de chaque tableau session
if (isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array_filter($_SESSION['panier'], fn($v) => $v != $id);
}
unset($_SESSION['personnalisation_panier'][$id]);
unset($_SESSION['prix_personnalise_panier'][$id]);

header("Location: panier.php");
exit();
