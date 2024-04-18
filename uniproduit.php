<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaFleur | Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/35413ab60a.js" crossorigin="anonymous"></script>
    <style>
    </style>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <!-- Barre de navigation -->
    <?php include 'navbar.php'; ?>

    <!-- Section des produits -->
    <section class="bg-white py-16">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <!-- Image du produit -->
                <div class="w-full md:w-1/2 p-4">
                    <img src="https://source.unsplash.com/1600x900/?flowers" alt="Fleurs" class="rounded-lg">
                </div>
                <!-- Détails du produit -->
                <div class="w-full md:w-1/2 p-4">
                    <h1 class="text-2xl md:text-4xl font-bold mb-4">Bois de rose et son vase offert</h1>
                    <!-- Sélection de la taille -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Sélectionnez la taille</label>
                        <div class="flex items-center mt-1">
                            <button class="bg-blue-500 text-white px-4 py-2 rounded-md mr-2">Normal</button>
                            <button class="bg-blue-500 text-white px-4 py-2 rounded-md">Grand</button>
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
    </section>

</body>

</html>
