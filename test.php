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
                            // Ajout du bouton Modifier avec l'overlay
                            echo "<td class='border-t flex flex-col h-full sm:flex-row mx-full border-gray-300 '>";
                            echo "<button id='toggleOverlay" . $row['id'] . "' class='text-blue-500 px-4 py-1 rounded mr-2'><i class=\"fa-solid fa-pen\"></i></button>";
                            echo "</td>";
                            echo "</tr>";

                            // Overlay pour chaque utilisateur
                            echo "<div id='overlay" . $row['id'] . "' class='fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50 hidden'>";
                            echo "<div class='bg-white p-8 rounded-lg shadow-lg max-w-lg'>";
                            echo "<h2 class='text-lg font-semibold mb-4'>Edit User</h2>";
                            // Formulaire d'édition
                            echo "<form method='post' action='edit_user.php'>";
                            echo "<input type='hidden' name='user_id' value='" . $row['id'] . "'>";
                            echo "<label class='block mb-2'>New Name:</label>";
                            echo "<input type='text' name='new_name' class='w-full border rounded-md mb-4'>";
                            echo "<button type='submit' class='bg-blue-500 text-white px-4 py-2 rounded'>Save Changes</button>";
                            echo "</form>";
                            echo "<button id='closeOverlay" . $row['id'] . "' class='mt-4 px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500'>Close</button>";
                            echo "</div>";
                            echo "</div>";

                            // Script pour afficher/masquer l'overlay
                            echo "<script>";
                            echo "document.getElementById('toggleOverlay" . $row['id'] . "').addEventListener('click', function() {";
                            echo "var overlay = document.getElementById('overlay" . $row['id'] . "');";
                            echo "overlay.classList.toggle('hidden');";
                            echo "});";
                            echo "document.getElementById('closeOverlay" . $row['id'] . "').addEventListener('click', function() {";
                            echo "var overlay = document.getElementById('overlay" . $row['id'] . "');";
                            echo "overlay.classList.add('hidden');";
                            echo "});";
                            echo "</script>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>

</html>