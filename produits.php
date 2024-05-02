<?php
session_start();
include './config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["categorie"])) {
        $categorie = $_POST["categorie"];
        $query = "SELECT id, nom, description, prix, image FROM fleur WHERE categorie = :categorie ORDER BY id DESC LIMIT 10";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':categorie', $categorie);
        $stmt->execute();
    } elseif (!empty($_POST["search"])) {
        $search = $_POST["search"];
        $search = strtolower($search);
        $query = "SELECT id, nom, description, prix, image FROM fleur WHERE LOWER(nom) LIKE :search ORDER BY id DESC LIMIT 10";
        $stmt = $conn->prepare($query);
        $search = "%$search%";
        $stmt->bindParam(':search', $search);
        $stmt->execute();
    } else {
        $query = "SELECT id, nom, description, prix, image FROM fleur ORDER BY id DESC LIMIT 10";
        $stmt = $conn->query($query);
    }
} else {
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
        body {
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-gray-200">

    <?php include 'navbar.php'; ?>

    <section class=" justify-center mt-12 flex  bg-cover ">

        <div class="container flex flex-col justify-center items-center ">
            <h1 class="text-4xl md:text-6xl text-black font-bold">Nos produits </h1>
            <div class="flex flex-col sm:flex-row gap-4 mt-12 flex flex-col justify-start items-start">
                <form method="post" class="mb-4 flex items-center justify-center">

                    <div class="relative">
                        <select name="categorie" id="categorie" class="border rounded p-2 pr-8 text-gray-800">
                            <option value="">Toutes les catégories</option>
                            <?php
                            $categoriesQuery = "SELECT id, description FROM categorie_fleur ORDER BY description ASC";
                            $categoriesResult = $conn->query($categoriesQuery);
                            while ($categorieRow = $categoriesResult->fetch(PDO::FETCH_ASSOC)) {
                                $selected = ($categorie === $categorieRow['id']) ? 'selected' : '';
                                echo '<option value="' . $categorieRow['id'] . '" ' . $selected . '>' . $categorieRow['description'] . '</option>';
                            }
                            ?>
                        </select>


                    </div>
                    <button type="submit"
                        class="ml-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Filtrer</button>
                </form>
                <form method="post" class="mb-4 flex items-center justify-center">
                    <div class="relative">
                        <input type="text" name="search" id="search" class="border rounded p-2 pr-8 text-gray-800"
                            placeholder="Entrez votre recherche">
                    </div>
                    <button type="submit"
                        class="ml-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Rechercher</button>
                </form>
            </div>


            <?php

            if ($stmt->rowCount() > 0) {
                ?>
                <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-8 mt-12">

                    <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <a href="uniproduit.php?id=<?php echo $row['id']; ?>">
                            <div class="flex flex-col sm:flex-row col-span-1 row-span-1 rounded-3xl">
                                <div class="card1 bg-white w-72 h-64 rounded-md text-black bg-white">
                                    <div class="Photo flex justify-center">
                                        <?php
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
                echo "Aucun résultat trouvé ";
            }

            $conn = null;
            ?>
        </div>
    </section>

</body>

</html>
