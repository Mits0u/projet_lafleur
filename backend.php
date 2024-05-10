<?php
// Inclure le fichier de configuration de la base de données
include './config/database.php';

// Vérifier si l'utilisateur est connecté
session_start();
// if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
//     header("Location: login.php");
//     exit;
// }

// Traitement de la suppression de produit
if (isset($_POST['delete_product'])) {
    $product_id = $_POST['product_id'];
    $query = "DELETE FROM fleur WHERE id = :id";
    $delstmt = $conn->prepare($query);
    $delstmt->bindParam(':id', $product_id);
    if ($delstmt->execute()) {
        // Redirection vers la même page après la suppression
        header("Location: backend.php");
        exit;
    } else {
        echo "Erreur lors de la suppression du produit.";
    }
}

if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user-id']; // Correction ici
    $query = "DELETE FROM utilisateur WHERE id = :id";
    $delstmtuser = $conn->prepare($query);
    $delstmtuser->bindParam(':id', $user_id); // Correction ici
    if ($delstmtuser->execute()) {
        // Redirection vers la même page après la suppression
        header("Location: backend.php");
        exit;
    } else {
        echo "Erreur lors de la suppression de l'utilisateur.";
    }
}

// Récupération des produits depuis la base de données
$query = "SELECT id, nom, description, prix, image FROM fleur ORDER BY id ";
$stmt = $conn->query($query);

// Récupération des produits depuis la base de données
$query2 = "SELECT utilisateur.*, type_compte.description FROM utilisateur, type_compte WHERE utilisateur.type_compte_id = type_compte.id ORDER BY utilisateur.id";
$userstmt = $conn->query($query2);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backend | Mon Site</title>
    <!-- Inclure Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/35413ab60a.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <section class="mx-auto max-w-6xl mt-12">


        <!-- Contenu de la page backend -->
        <div>
            <h2 class="text-2xl font-semibold mb-4">Tableau de bord user</h2>
            <div class="overflow-scroll h-64">

                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">ID</th>
                            <th class="border border-gray-300 px-4 py-2">Type compte id</th>
                            <th class="border border-gray-300 px-4 py-2">Nom</th>
                            <th class="border border-gray-300 px-4 py-2">Prenom</th>
                            <th class="border border-gray-300 px-4 py-2">Email</th>
                            <th class="border border-gray-300 px-4 py-2">Date de creation</th>
                            <th class="border border-gray-300 px-4 py-2">Adresse</th>
                            <th class="border border-gray-300 px-4 py-2">Code postal</th>
                            <th class="border border-gray-300 px-4 py-2">ville</th>
                            <th class="border border-gray-300 px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Affichage des produits
                        while ($row = $userstmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td class='border border-gray-300 px-4 py-2'>" . $row['id'] . "</td>";
                            echo "<td class='border border-gray-300 px-4 py-2'>" . $row['description'] . "</td>";
                            echo "<td class='border border-gray-300 px-4 py-2'>" . $row['nom'] . "</td>";
                            echo "<td class='border border-gray-300 px-4 py-2'>" . $row['prenom'] . "</td>";
                            echo "<td class='border border-gray-300 px-4 py-2'>" . $row['email'] . "</td>";
                            echo "<td class='border border-gray-300 px-4 py-2'>" . $row['date_creation'] . "</td>";
                            echo "<td class='border border-gray-300 px-4 py-2'>" . $row['adresse'] . "</td>";
                            echo "<td class='border border-gray-300 px-4 py-2'>" . $row['code_postal'] . "</td>";
                            echo "<td class='border border-gray-300 px-4 py-2'>" . $row['ville'] . "</td>";
                            // Ajout des boutons Modifier et Supprimer
                            echo "<td class='border-t flex flex-col h-full sm:flex-row mx-full border-gray-300 '>";
                            echo "<form method='post' action='edit_user.php?id=". $row['id'] .";'>";
                            echo "<input type='hidden' name='user_id' value='" . $row['id'] . "'>";
                            echo "<button type='submit' name='edit_user' class=' text-blue-500 px-4 py-1 rounded mr-2'><i class=\"fa-solid fa-pen\"></i></button>";
                            echo "</form>";
                            echo "<form method='post'>";
                            echo "<input type='hidden' name='user-id' value='" . $row['id'] . "'>";
                            echo "<button type='submit' name='delete_user' class='text-red-500 px-4 py-1 rounded'><i class=\"fa-solid fa-trash\"></i></button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <div>
                <h2 class="text-2xl font-semibold mb-4 mt-8">Tableau de bord fleur</h2>
                <div class="overflow-scroll h-96">

                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr>
                                <th class="border border-gray-300 px-4 py-2">ID</th>
                                <th class="border border-gray-300 px-4 py-2">Nom</th>
                                <th class="border border-gray-300 px-4 py-2">Description</th>
                                <th class="border border-gray-300 px-4 py-2">Prix</th>
                                <th class="border border-gray-300 px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Affichage des produits
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td class='border border-gray-300 px-4 py-2'>" . $row['id'] . "</td>";
                                echo "<td class='border border-gray-300 px-4 py-2'>" . $row['nom'] . "</td>";
                                echo "<td class='border border-gray-300 px-4 py-2'>" . $row['description'] . "</td>";
                                echo "<td class='border border-gray-300 px-4 py-2'>" . $row['prix'] . "</td>";
                                // Ajout des boutons Modifier et Supprimer
                                echo "<td class='border-t flex flex-col h-full sm:flex-row mx-full border-gray-300 '>";
                                echo "<form method='post' action='edit_product.php?id=". $row['id'] .";'>";
                                echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
                                echo "<button type='submit' name='edit_product' class='text-blue-500  px-4 py-1 rounded mr-2'><i class=\"fa-solid fa-pen\"></i></button>";
                                echo "</form>";
                                echo "<form method='post'>";
                                echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
                                echo "<button type='submit' name='delete_product' class='text-red-500  px-4 py-1 rounded'><i class=\"fa-solid fa-trash\"></i></button>";
                                echo "</form>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </section>
</body>

</html>