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
    </style>
</head>

<body class=" font-sans leading-normal tracking-normal">

    <!-- Barre de navigation -->
    <?php include 'navbar.php'; ?>

    <!-- Section des produits -->
    <section class=" mx-6 md:mx-16 rounded-md">
        <div class="container mt-8 ">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <!-- Image du produit -->
                <div class="p-4">
                    <img src="https://source.unsplash.com/1600x900/?tulip" alt="Fleurs" class="rounded-lg">
                </div>
                <!-- Détails du produit -->
                <div class="p-4">
                    <h1 class="text-2xl md:text-4xl font-bold mb-4">Bois de rose et son vase non-offert</h1>
                    <!-- Sélection de la taille -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Sélectionnez la taille</label>
                        <div class="flex items-center mt-1">
                            <button class="bg-green-500 text-white px-4 py-2 rounded-md mr-2">Normal</button>
                            <button class="bg-green-500 text-white px-4 py-2 rounded-md">Grand</button>
                        </div>
                    </div>
                    <!-- Prix -->
                    <div class="text-3xl md:text-4xl font-bold text-gray-700 mb-4">64,95€</div>
                    <!-- Vase offert -->
                    <div class="flex items-center text-gray-600 mb-4">
                        <i class="fas fa-gift mr-2"></i>
                        <span>Vase non-offert + 15,95€</span>
                    </div>
                    <!-- Bouton Ajouter au panier -->
                    <button class="bg-green-500 text-white px-6 py-3 rounded-md mb-4">Ajouter au panier</button>
                    <!-- Paiement en 3x sans frais -->
                    <div class="text-sm text-gray-600">Payer en 18x avec frais de 50€</div>
                </div>
            </div>

        </div>
        <div class="mx-4">
            <h1 class="text-2xl font-bold">
                Vous aimerez aussi :
            </h1>
        </div>
        <div class="mx-4 ">
            <div class="swiper-container h-86 flex overflow-hidden mt-8 justify-center items-center">

                <div class="swiper-wrapper">

                    <a href="#">
                        <div class="testclass rainy swiper-slide relative  rounded-2xl   ">
                            <div class="image1 relative  h-32 w-64">
                                <a href="#">
                                    <img src="https://source.unsplash.com/1600x900/?tulip" alt="Image par défaut"
                                        class="w-full h-full rounded-2xl object-cover">


                                </a>
                            </div>
                            <div class="flex items-center w-64 bg-green-500 mt-2 rounded-md justify-center ">
                                <p class="text-white ">
                                    Tulip classique
                                </p>
                            </div>
                        </div>
                    </a>


                    <a href="#">
                        <div class="testclass rainy swiper-slide relative  rounded-2xl   ">
                            <div class="image1 relative  h-32 w-64">
                                <a href="#">
                                    <img src="https://source.unsplash.com/1600x900/?tulip" alt="Image par défaut"
                                        class="w-full h-full rounded-2xl object-cover">
                                </a>
                            </div>
                            <div class="flex items-center w-64 bg-green-500 mt-2 rounded-md justify-center ">
                                <p class="text-white ">
                                    Tulip classique
                                </p>
                            </div>
                        </div>
                    </a>

                    <a href="#">
                        <div class="testclass rainy swiper-slide relative  rounded-2xl   ">
                            <div class="image1 relative  h-32 w-64">
                                <a href="#">
                                    <img src="https://source.unsplash.com/1600x900/?tulip" alt="Image par défaut"
                                        class="w-full h-full rounded-2xl object-cover">
                                </a>
                            </div>
                            <div class="flex items-center w-64 bg-green-500 mt-2 rounded-md justify-center ">
                                <p class="text-white ">
                                    Tulip classique
                                </p>
                            </div>
                        </div>
                    </a>

                    <a href="#">
                        <div class="testclass rainy swiper-slide relative  rounded-2xl   ">
                            <div class="image1 relative  h-32 w-64">
                                <a href="#">
                                    <img src="https://source.unsplash.com/1600x900/?tulip" alt="Image par défaut"
                                        class="w-full h-full rounded-2xl object-cover">


                                </a>
                            </div>
                            <div class="flex items-center w-64 bg-green-500 mt-2 rounded-md justify-center ">
                                <p class="text-white ">
                                    Tulip classique
                                </p>
                            </div>
                        </div>
                    </a>

                    <a href="#">
                        <div class="testclass rainy swiper-slide relative  rounded-2xl   ">
                            <div class="image1 relative  h-32 w-64">
                                <a href="#">
                                    <img src="https://source.unsplash.com/1600x900/?tulip" alt="Image par défaut"
                                        class="w-full h-full rounded-2xl object-cover">


                                </a>
                            </div>
                            <div class="flex items-center w-64 bg-green-500 mt-2 rounded-md justify-center ">
                                <p class="text-white ">
                                    Tulip classique
                                </p>
                            </div>
                        </div>
                    </a>

                    <a href="#">
                        <div class="testclass rainy swiper-slide relative  rounded-2xl   ">
                            <div class="image1 relative  h-32 w-64">
                                <a href="#">
                                    <img src="https://source.unsplash.com/1600x900/?tulip" alt="Image par défaut"
                                        class="w-full h-full rounded-2xl object-cover">


                                </a>
                            </div>
                            <div class="flex items-center w-64 bg-green-500 mt-2 rounded-md justify-center ">
                                <p class="text-white ">
                                    Tulip classique
                                </p>
                            </div>
                        </div>
                    </a>


                </div>

                <script>
                    var swiper;

                    function initSwiper() {
                        var slidesPerView = (window.innerWidth < 768) ? 1 : 4; // Si l'écran est petit, affiche une seule image, sinon deux.

                        swiper = new Swiper('.swiper-container', {
                            slidesPerView: slidesPerView,
                            spaceBetween: 20,
                            loop: true,
                            navigation: {
                                nextEl: '.swiper-button-next',
                                prevEl: '.swiper-button-prev',
                            },
                            pagination: {
                                el: '.swiper-pagination',
                                clickable: true,
                            },
                            autoplay: {
                                delay: 4000,
                                disableOnInteraction: false,
                            },
                        });

                        // Gestion des événements de survol pour la pause/reprise du défilement
                        var swiperContainer = document.querySelector('.swiper-container');

                        swiperContainer.addEventListener('mouseenter', function () {
                            swiper.autoplay.stop();
                        });

                        swiperContainer.addEventListener('mouseleave', function () {
                            swiper.autoplay.start();
                        });
                    }

                    // Appeler la fonction initSwiper au chargement de la page
                    window.addEventListener('load', function () {
                        initSwiper();

                        // Mettre à jour le nombre de slides visibles si la fenêtre est redimensionnée
                        window.addEventListener('resize', function () {
                            swiper.destroy(); // Détruire l'instance Swiper existante
                            initSwiper(); // Initialiser une nouvelle instance Swiper
                        });
                    });
                </script>
            </div>
        </div>

    </section>

</body>

</html>