<?php
session_start();
include './config/database.php';

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user']['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Utilisateur non connecté']);
    exit;
}

$user_id = $_SESSION['user']['id'];

try {
    // Supprimer les commandes associées à l'utilisateur
    $stmt_delete_commande = $conn->prepare("DELETE FROM commande WHERE id_utilisateur = :user_id");
    $stmt_delete_commande->bindParam(':user_id', $user_id);
    $stmt_delete_commande->execute();

    // Supprimer les entrées dans la table junction_panier_fleur
    $stmt_delete_junction = $conn->prepare("DELETE FROM junction_panier_fleur WHERE id_panier IN (SELECT id FROM panier WHERE id IN (SELECT id_panier FROM commande WHERE id_utilisateur = :user_id))");
    $stmt_delete_junction->bindParam(':user_id', $user_id);
    $stmt_delete_junction->execute();

    // Supprimer le panier de l'utilisateur
    $stmt_delete_panier = $conn->prepare("DELETE FROM panier WHERE id IN (SELECT id_panier FROM commande WHERE id_utilisateur = :user_id)");
    $stmt_delete_panier->bindParam(':user_id', $user_id);
    $stmt_delete_panier->execute();

    echo json_encode(['status' => 'success', 'message' => 'Panier de l\'utilisateur supprimé avec succès']);
} catch(PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la suppression du panier de l\'utilisateur: ' . $e->getMessage()]);
}

$conn = null;
?>
