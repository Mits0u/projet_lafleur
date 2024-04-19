<?php

session_start();
include './config/database.php';

$id_utilisateur = $_SESSION['user']['id'];

$sql = "SELECT p.id, jf.quantite, pr.nom, pr.prix, pr.image
        FROM panier p
        INNER JOIN junction_panier_fleur jf ON p.id = jf.id_panier
        INNER JOIN fleur pr ON jf.id_fleur = pr.id
        WHERE p.id = (SELECT id_panier FROM commande WHERE id_utilisateur = :id_utilisateur)";

$query = $conn->prepare($sql);
$query->execute(['id_utilisateur' => $id_utilisateur]);
$result = $query->fetchAll();

$cart = [
    'products' => [],
    'total' => 0
];

foreach ($result as $row) {
    $cart['products'][] = [
        'id' => $row['id'],
        'name' => $row['nom'],
        'price' => $row['prix'],
        'quantity' => $row['quantite'],
        'image' => base64_encode($row['image'])
    ];
    $cart['total'] += $row['prix'] * $row['quantite'];
}

echo json_encode($cart);
?>
