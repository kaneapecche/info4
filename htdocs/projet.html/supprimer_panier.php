<?php
session_start();

$voyageId = $_POST['voyageId'] ?? null;

if ($voyageId && isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array_filter($_SESSION['panier'], fn($id) => $id != $voyageId);
    echo "Supprimé.";
} else {
    echo "Erreur.";
}
