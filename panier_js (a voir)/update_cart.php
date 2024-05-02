<?php
session_start();
include './config/database.php';

if (!isset($_SESSION['user']['id'])) {
    echo json_encode(['error' => 'Veuillez vous connecter pour accéder à votre panier']);
    exit;
}

$id_utilisateur = $_SESSION['user']['id'];

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->productId) || !isset($data->quantityChange)) {
    echo json_encode(['error' => 'Données manquantes']);
    exit;
}

$productId = $data->productId;
$quantityChange = $data->quantityChange;

$sql_panier = "SELECT id_panier FROM commande WHERE id_utilisateur = :id_utilisateur";
$query_panier = $conn->prepare($sql_panier);
$query_panier->execute(['id_utilisateur' => $id_utilisateur]);
$panier = $query_panier->fetch();

if (!$panier) {
    echo json_encode(['error' => 'Panier non trouvé pour cet utilisateur']);
    exit;
}

$id_panier = $panier['id_panier'];

// Vérification si le produit existe dans le panier
$sql_produit = "SELECT quantite FROM junction_panier_fleur WHERE id_fleur = :productId AND id_panier = :id_panier";
$query_produit = $conn->prepare($sql_produit);
$query_produit->execute(['productId' => $productId, 'id_panier' => $id_panier]);
$result = $query_produit->fetch();

if (!$result) {
    echo json_encode(['error' => 'Produit non trouvé dans le panier']);
    exit;
}

$currentQuantity = $result['quantite'];
$newQuantity = $currentQuantity + $quantityChange;

if ($newQuantity <= 0) {
    $sql = "DELETE FROM junction_panier_fleur WHERE id_fleur = :productId AND id_panier = :id_panier";
    $query = $conn->prepare($sql);
    $query->execute(['productId' => $productId, 'id_panier' => $id_panier]);
} else {
    $sql = "UPDATE junction_panier_fleur SET quantite = :newQuantity WHERE id_fleur = :productId AND id_panier = :id_panier";
    $query = $conn->prepare($sql);
    $query->execute(['newQuantity' => $newQuantity, 'productId' => $productId, 'id_panier' => $id_panier]);
}

// Renvoyer les données mises à jour du panier
include 'get_cart.php';
?>