<?php

session_start();

include 'navbar.php';
include './config/database.php';

// Récupération de l'ID depuis la requête GET
$id = isset($_GET['id']) ? $_GET['id'] : null;

$result = null;
if ($id) {
    // Sélection des données de plat avec l'ID spécifié
    $sql = "SELECT * FROM fleur WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['submit'])) {
    // Vérification et récupération des valeurs du formulaire
    $nom = isset($_POST['nom']) ? $_POST['nom'] : null;
    $description = isset($_POST['description']) ? $_POST['description'] : null;
    $prix = isset($_POST['prix']) ? $_POST['prix'] : null;
    $categorie = isset($_POST['categorie']) ? $_POST['categorie'] : null;

    $image = $_FILES['image']['name'];
    $image = file_get_contents($_FILES['image']['tmp_name']);

    // Exécution de la commande UPDATE pour mettre à jour le nom de plat
    if ($nom && $id) {
        $sql = "UPDATE fleur SET nom = :nom, description = :description, prix = :prix, categorie = :categorie, image = :image WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->bindParam(':nom', $nom, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':prix', $prix, PDO::PARAM_STR);
        $query->bindParam(':categorie', $categorie, PDO::PARAM_STR);
        $query->bindParam(':image', $image, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        // Redirection vers back.php après la mise à jour
        header('Location: backend.php');
        exit;
    } else {
        echo "Erreur: Veuillez fournir un nom valide.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un plat</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/35413ab60a.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-200">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-4">Modifier un plat</h1>
        <form method="post" action="edit_product.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
            <div class="flex flex-col mb-4">
                <label class="mb-2 font-semibold" for="nom">Nom</label>
                <input class="border border-gray-300 p-4 rounded-md" type="text" name="nom" id="nom"
                    value="<?php echo isset($result['nom']) ? $result['nom'] : ''; ?>">
            </div>
            <div class="flex flex-col mb-4">
                <label class="mb-2 font-semibold" for="description">Description</label>
                <input class="border border-gray-300 p-4 rounded-md" type="text" name="description" id="description"
                    value="<?php echo isset($result['description']) ? $result['description'] : ''; ?>">
            </div>
            <div class="flex flex-col mb-4">
                <label class="mb-2 font-semibold" for="prix">Prix</label>
                <input class="border border-gray-300 p-4 rounded-md" type="text" name="prix" id="prix"
                    value="<?php echo isset($result['prix']) ? $result['prix'] : ''; ?>">
            </div>
            <div class="flex flex-col mb-4">
                <label class="mb-2 font-semibold" for="categorie">Categorie</label>
                <input class="border border-gray-300 p-4 rounded-md" type="text" name="categorie" id="categorie"
                    value="<?php echo isset($result['categorie']) ? $result['categorie'] : ''; ?>">
            </div>
            <div class=" mb-4 ">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Image</label>
                <input type="file" name="image" id="image"
                    class="w-full p-4 border rounded shadow appearance-none focus:outline-none focus:shadow-outline-blue">
            </div>
            <div class="flex flex-col md:flex-row gap-4">
                <button class="bg-green-700 text-white w-full p-4 rounded-md mt-4" type="submit"
                    name="submit">Modifier</button>
            </div>
        </form>
    </div>

</body>

</html>