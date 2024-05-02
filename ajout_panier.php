<?php
session_start();
include './config/database.php';

if (isset($_GET['id'])) {
    $article_id = $_GET['id'];
    $utilisateur_id = $_SESSION['user']['id'];

    $existing_panier_query = "SELECT id_panier FROM commande WHERE id_utilisateur = :utilisateur_id AND id_panier IS NOT NULL";
    $existing_panier_stmt = $conn->prepare($existing_panier_query);
    $existing_panier_stmt->bindParam(':utilisateur_id', $utilisateur_id, PDO::PARAM_INT);
    $existing_panier_stmt->execute();
    $existing_panier = $existing_panier_stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_panier) {
        $panier_id = $existing_panier['id_panier'];
    } else {
        $query_panier = "INSERT INTO panier (prix_panier, nombre_articles, date_panier) VALUES (0, 0, NOW())";
        $reqstmt_panier = $conn->prepare($query_panier);
        $reqstmt_panier->execute();
        $panier_id = $conn->lastInsertId();

        $query_commande = "INSERT INTO commande (id_utilisateur, id_panier) VALUES (:id_utilisateur, :id_panier)";
        $reqstmt_commande = $conn->prepare($query_commande);
        $reqstmt_commande->bindParam(':id_utilisateur', $utilisateur_id, PDO::PARAM_INT);
        $reqstmt_commande->bindParam(':id_panier', $panier_id, PDO::PARAM_INT);
        $reqstmt_commande->execute();
    }

    $existing_article_query = "SELECT id FROM junction_panier_fleur WHERE id_panier = :panier_id AND id_fleur = :article_id";
    $existing_article_stmt = $conn->prepare($existing_article_query);
    $existing_article_stmt->bindParam(':panier_id', $panier_id, PDO::PARAM_INT);
    $existing_article_stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
    $existing_article_stmt->execute();
    $existing_article = $existing_article_stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_article) {
        $update_quantity_query = "UPDATE junction_panier_fleur SET quantite = quantite + 1 WHERE id = :article_id";
        $update_quantity_stmt = $conn->prepare($update_quantity_query);
        $update_quantity_stmt->bindParam(':article_id', $existing_article['id'], PDO::PARAM_INT);
        $update_quantity_stmt->execute();
    } else {
        $sql = 'SELECT * FROM fleur WHERE id = :article_id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
        $stmt->execute();
        $article = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($article) {
            $insert_jonction_query = "INSERT INTO junction_panier_fleur (id_panier, id_fleur, quantite) VALUES (:id_panier, :id_fleur, 1)";
            $insert_jonction_stmt = $conn->prepare($insert_jonction_query);
            $insert_jonction_stmt->bindParam(':id_panier', $panier_id, PDO::PARAM_INT);
            $insert_jonction_stmt->bindParam(':id_fleur', $article_id, PDO::PARAM_INT);
            $insert_jonction_stmt->execute();

            $update_panier_query = "UPDATE panier SET prix_panier = (SELECT SUM(prix) FROM fleur INNER JOIN junction_panier_fleur ON fleur.id = junction_panier_fleur.id_fleur WHERE junction_panier_fleur.id_panier = :panier_id), nombre_articles = nombre_articles + 1 WHERE id = :panier_id";
            $update_panier_stmt = $conn->prepare($update_panier_query);
            $update_panier_stmt->bindParam(':panier_id', $panier_id, PDO::PARAM_INT);
            $update_panier_stmt->execute();
        }
    }

    header("Location: panier.php");
    exit();
} else {
    header("Location: produits.php");
    exit();
}
?>
