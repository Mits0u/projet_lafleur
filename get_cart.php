<?php
session_start();
include './config/database.php';

if (!isset($_SESSION['user']['id'])) {
    echo json_encode(['error' => 'Veuillez vous connecter pour accéder à votre panier']);
    exit;
}

$id_utilisateur = $_SESSION['user']['id'];

$sql = "SELECT jf.id_fleur, jf.quantite, f.nom, f.prix
        FROM junction_panier_fleur jf
        INNER JOIN fleur f ON jf.id_fleur = f.id
        WHERE jf.id = :id_utilisateur";

$query = $conn->prepare($sql);
$query->execute(['id_utilisateur'=> $id_utilisateur]);
$result = $query->fetchAll();

if (empty($result)) {
echo json_encode(['products' => [], 'total' => 0, 'message' => 'Votre panier est vide']);
exit;
}

$cart = [
'products' => [],
'total' => 0
];

foreach ($result as $row) {
$cart['products'][] = [
'id' => $row['id_fleur'],
'name' => $row['nom'],
'price' => $row['prix'],
'quantity' => $row['quantite']
];
$cart['total'] += $row['prix'] * $row['quantite'];
}

echo json_encode($cart);
?>