
<?php
include './config/database.php';

// Initialisation des variables
$article_nom = '';
$article_description = '';
$article_prix = '';
$article_categorie = '';
$article_image = '';

// Vérifier si l'ID de l'article est passé dans l'URL
if (isset($_GET['id'])) {
    // Récupérer l'ID de l'article depuis l'URL
    $fleur_id = $_GET['id'];

    // Requête SQL pour récupérer les informations de l'article depuis la base de données
    $sql = 'SELECT * FROM fleur WHERE id = :fleur_id';

    // Préparation de la requête
    $stmt = $conn->prepare($sql);

    // Liaison du paramètre :fleur_id avec la valeur de l'ID de l'article
    $stmt->bindParam(':fleur_id', $fleur_id, PDO::PARAM_INT);

    // Exécution de la requête
    $stmt->execute();

    // Récupération des résultats dans un tableau associatif
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'article existe
    if ($article) {
        // Récupérer les informations de l'article
        $article_id = $article['id'];
        $article_nom = $article['nom'];
        $article_description = $article['description'];
        $article_prix = $article['prix'];
        $article_categorie = $article['categorie'];
        $article_image = $article['image'];
    } else {
        // Redirection vers une autre page si l'article n'est pas trouvé
        header("Location: produits.php");
        exit();
    }
} else {
    // Redirection vers une autre page si l'ID de l'article n'est pas passé dans l'URL
    header("Location: produits.php");
    exit();
}

// Requête SQL pour récupérer les fleurs avec la même catégorie que l'article actuel
$query = "SELECT id, nom, description, prix, image FROM fleur WHERE categorie = :categorie AND id != :article_id ORDER BY id DESC LIMIT 4";

// Préparation de la requête
$reqstmt = $conn->prepare($query);

// Liaison du paramètre :categorie avec la valeur de la catégorie de l'article
$reqstmt->bindParam(':categorie', $article_categorie, PDO::PARAM_STR);
// Liaison du paramètre :article_id avec la valeur de l'ID de l'article
$reqstmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);

// Exécution de la requête
$reqstmt->execute();

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaFleur | Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/35413ab60a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <style>
        body {
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-gray-200 h-screen ">

    <!-- Barre de navigation -->
    <?php include 'navbar.php'; ?>

    <!-- Section des produits -->
    <section class="container mx-auto lg:max-w-7xl">

        <div class=" mt-24  ">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 flex items-center">
                <!-- Image du produit -->
                <div class="p-4">
                    <?php
                    // Assurez-vous que $row['image'] contient les données binaires de l'image encodées en base64
                    $imageData = base64_encode($article_image);
                    echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="image' . $article_nom . '" class="rounded-lg object-cover h-72  w-full">';
                    ?>
                </div>
                <!-- Détails du produit -->
                <div class="p-4">
                    <h1 class="text-2xl md:text-4xl font-bold mb-4"><?php echo $article_nom ?></h1>
                    <!-- Sélection de la taille -->
                    <div class="mb-4">
                        <?php echo $article_description ?>
                    </div>
                    <!-- Prix -->
                    <div class="text-3xl md:text-4xl font-bold text-black mb-4"><?php echo $article_prix ?>€</div>
                    <!-- Vase offert -->

                    <!-- Bouton Ajouter au panier -->
                    <button class="bg-green-500 text-white px-6 py-3 rounded-md mb-4">Ajouter au panier</button>


                </div>
            </div>

        </div>
        <div class="mx-4 mt-12">
            <h1 class="text-2xl font-bold">
                Vous aimerez aussi :
            </h1>
        </div>
        <div class="mx-4 ">
            <div class="swiper-container h-86 flex overflow-hidden mt-8 gap-8 justify-start items-center">
                <?php
                if ($reqstmt->rowCount() > 0) {
                    ?>
                    <div class="flex flex-col sm:flex-row ">
                        <?php
                        while ($row = $reqstmt->fetch(PDO::FETCH_ASSOC)) {

                            ?>
                            <a href="uniproduit.php?id=<?php echo $row['id']; ?>">
                                <div class="testclass rainy swiper-slide relative rounded-2xl">
                                    <div class="image1 relative h-32 w-64">
                                        <?php
                                        // Assurez-vous que $row['image'] contient les données binaires de l'image encodées en base64
                                        $imageData = base64_encode($row['image']);
                                        echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="image' . $row['nom'] . '" class="w-full h-full rounded-2xl object-cover">';
                                        ?>
                                    </div>
                                    <div class="flex items-center w-64 bg-green-500 mt-2 rounded-md justify-center">
                                        <p class="text-white">
                                            <?php echo $row['nom'] . ' :'; ?>
                                        </p>
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
                ?>
            </div>
        </div>



    </section>

</body>

</html>
