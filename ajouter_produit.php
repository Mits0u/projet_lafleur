<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/35413ab60a.js" crossorigin="anonymous"></script>
</head>
<?php
include './config/database.php';

session_start();

if (isset($_POST)) {
    if (
        isset($_POST['nom']) && !empty($_POST['nom'])
        && isset($_POST['description']) && !empty($_POST['description'])
        && isset($_POST['prix']) && !empty($_POST['prix'])
        && isset($_POST['categorie']) && !empty($_POST['categorie'])
    ) {
        $nom = strip_tags($_POST['nom']);
        $description = strip_tags($_POST['description']);
        $prix = strip_tags($_POST['prix']);
        $categorie = strip_tags($_POST['categorie']);

        $image = $_FILES['image']['name'];
        $image = file_get_contents($_FILES['image']['tmp_name']);

        $sql = "INSERT INTO `fleur` (`nom`, `description`, `prix`, `categorie`, `image`) VALUES (:nom, :description, :prix, :categorie, :image)";


        $query = $conn->prepare($sql);

        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':description', $description, PDO::PARAM_STR);
        $query->bindValue(':prix', $prix, PDO::PARAM_STR);
        $query->bindValue(':categorie', $categorie, PDO::PARAM_STR);
        $query->bindValue(':image', $image, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['message'] = "Produit ajouté avec succès !";
        header('Location: backend.php');
    }
}

include 'navbar.php';
?>

<body class="bg-gray-200">
    <div class="container mx-auto">
        <form method="post" class="w-full mx-auto my-8 p-4 rounded " enctype="multipart/form-data">
            <div class="mb-4">
                <label for="nom" class="block text-gray-700 text-sm font-bold mb-2">Nom</label>
                <input type="text" name="nom" id="nom"
                    class="w-full p-4 border rounded shadow appearance-none focus:outline-none focus:shadow-outline-blue">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <input type="text" name="description" id="description"
                    class="w-full p-4 border rounded shadow appearance-none focus:outline-none focus:shadow-outline-blue">
            </div>
            <div class="mb-4">
                <label for="prix" class="block text-gray-700 text-sm font-bold mb-2">Prix</label>
                <input type="float" name="prix" id="prix"
                    class="w-full p-4 border rounded shadow appearance-none focus:outline-none focus:shadow-outline-blue">
            </div>
            <div class="mb-4">
                <label for="categorie" class="block text-sm font-bold font-semibold">Catégorie</label>
                <select name="categorie" id="categorie" class="w-full border p-4 rounded">
                    <?php
                    try {
                        $conn = new PDO("mysql:host=localhost;dbname=projet_lafleur", "root", "");
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // Récupération des catégories depuis la base de données
                        $query2 = $conn->query("SELECT * FROM categorie_fleur;");
                        $categories = $query2->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($categories as $category) {
                            $selected = ($category['id'] == $result['categorie_id']) ? 'selected' : '';
                            $idcat = $category['id'];
                            $iddes = $category['description'];

                            // Générer l'option pour chaque catégorie
                            ?>
                            <option <?= $selected ?> value="<?= $idcat ?>">
                                <?= $iddes ?>
                            </option>
                            <?php
                        }
                    } catch (PDOException $e) {
                        echo "Connection failed: " . $e->getMessage();
                    }
                    ?>
                </select>
            </div>
            <div class=" mb-4 ">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Image</label>
                <input type="file" name="image" id="image"
                    class="w-full p-4 border rounded shadow appearance-none focus:outline-none focus:shadow-outline-blue">
            </div>

            <div class="flex flex-row gap-2 w-full">
                <button class="p-4 bg-green-500 rounded-md text-white w-full" type="submit">Enregistrer</button>
                <button class="p-4 bg-green-500 rounded-md text-white w-full" type="button"
                    onclick="window.location.href='backend.php'">Retour</button>
            </div>
        </form>
    </div>
</body>

</html>