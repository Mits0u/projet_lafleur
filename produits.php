<?php
include './config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si une catégorie a été sélectionnée
    if (!empty($_POST["categorie"])) {
        $categorie = $_POST["categorie"];
        // Modifier la requête SQL pour sélectionner les produits de la catégorie sélectionnée
        $query = "SELECT id, nom, description, prix, image FROM fleur WHERE categorie = :categorie ORDER BY id DESC LIMIT 10";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':categorie', $categorie);
        $stmt->execute();
    } else {
        // Si aucune catégorie n'est sélectionnée, récupérez tous les produits
        $query = "SELECT id, nom, description, prix, image FROM fleur ORDER BY id DESC LIMIT 10";
        $stmt = $conn->query($query);
    }
} else {
    // Si le formulaire n'a pas été soumis, récupérez tous les produits par défaut
    $query = "SELECT id, nom, description, prix, image FROM fleur ORDER BY id DESC LIMIT 10";
    $stmt = $conn->query($query);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaFleur | Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/35413ab60a.js" crossorigin="anonymous"></script>
    <style>
    </style>
</head>

<body class="bg-gray-200">

    <?php include 'navbar.php'; ?>

    <section class=" justify-center mt-12 flex  bg-cover ">

        <div class="container flex flex-col justify-center items-center ">
            <h1 class="text-4xl md:text-6xl text-black font-bold">Nos produits </h1>

            <form method="post" class="mb-4 flex items-center justify-center">
                
                <div class="relative">
                    <select name="categorie" id="categorie" class="border rounded p-2 pr-8 text-gray-800">
                        <option value="">Toutes les catégories</option>
                        <?php
                        // Requête pour récupérer les libellés des catégories
                        $categoriesQuery = "SELECT id, description FROM categorie_fleur ORDER BY description ASC";
                        $categoriesResult = $conn->query($categoriesQuery);
                        while ($categorieRow = $categoriesResult->fetch(PDO::FETCH_ASSOC)) {
                            // Vérifier si cette catégorie est celle sélectionnée
                            $selected = ($categorie === $categorieRow['id']) ? 'selected' : '';
                            echo '<option value="' . $categorieRow['id'] . '" ' . $selected . '>' . $categorieRow['description'] . '</option>';
                        }
                        ?>
                    </select>
                    
                </div>
                <button type="submit"
                    class="ml-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Filtrer</button>
            </form>

            <?php

            $result = $conn->query("SELECT id, nom, description, prix, image FROM fleur ORDER BY id DESC LIMIT 10");

            // Vérification s'il y a des résultats
            if ($result->rowCount() > 0) {
                ?>
                <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-8 mt-24">

                    <?php
                    // Boucle à travers les résultats
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <a href="uniproduit.php">
                            <div class="flex flex-col sm:flex-row col-span-1 row-span-1 rounded-3xl">
                                <div class="card1 bg-white w-72 h-64 rounded-md text-black bg-white">
                                    <div class="Photo flex justify-center">
                                        <?php
                                        // Assurez-vous que $row['image'] contient les données binaires de l'image encodées en base64
                                        $imageData = base64_encode($row['image']);
                                        echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="image' . $row['id'] . '" class="h-44 w-full object-cover rounded-t-md">';
                                        ?>
                                    </div>

                                    <div class="flex flex-col p-4">
                                        <div class="flex justify-start">
                                            <h1 class="text-2xl font-bold"><?php echo $row['nom'] . ' :'; ?></h1>
                                        </div>
                                        <div class="flex flex-row items-center gap-1">
                                            <p class="text-md">dès</p>
                                            <p class="text-lg font-bold"><?php echo $row['prix'] . ' €.'; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php
                    }
                    ?>
                </div>
                <?php
            } else {
                echo "Aucun résultat trouvé dans la base de données.";
            }

            // Fermer la connexion à la base de données
            $conn = null;
            ?>
        </div>
    </section>

</body>

</html>