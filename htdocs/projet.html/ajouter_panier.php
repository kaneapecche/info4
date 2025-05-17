<?php
session_start();

$id = $_GET['id'] ?? null;


// Créer tableau de panier si pas encore fait
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Ajouter le voyage au panier
if (!in_array($id, $_SESSION['panier'])) {
    $_SESSION['panier'][] = $id;
}

// Enregistrer la personnalisation du voyage
if (isset($_SESSION['personnalisation'][$id])) {
    $_SESSION['personnalisation_panier'][$id] = $_SESSION['personnalisation'][$id];
}

// Enregistrer le prix personnalisé si calculé
if (isset($_SESSION['prix_personnalise'][$id])) {
    $_SESSION['prix_personnalise_panier'][$id] = $_SESSION['prix_personnalise'][$id];
}

// Rediriger vers le panier
header("Location: panier.php");
exit();

// Rediriger vers le panier
header("Location: panier.php");
exit();
