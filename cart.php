<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaFleur | Panier</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/35413ab60a.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <section class="container mx-auto mt-16">
        <h2 class="text-2xl font-bold text-center">Panier</h2>
        <table class="w-full mt-8">
            <thead>
                <tr>
                    <th class="border-b-2 border-gray-300 py-2">Produit</th>
                    <th class="border-b-2 border-gray-300 py-2">Prix</th>
                    <th class="border-b-2 border-gray-300 py-2">Quantité</th>
                    <th class="border-b-2 border-gray-300 py-2">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border-b border-gray-300 py-2">Rose rouge</td>
                    <td class="border-b border-gray-300 py-2">20€</td>
                    <td class="border-b border-gray-300 py-2">1</td>
                    <td class="border-b border-gray-300 py-2">20€</td>
                </tr>
                <tr>
                    <td class="border-b border-gray-300 py-2">Lys blanc</td>
                    <td class="border-b border-gray-300 py-2">25€</td>
                    <td class="border-b border-gray-300 py-2">2</td>
                    <td class="border-b border-gray-300 py-2">50€</td>
                </tr>
                <tr>
                    <td class="border-b border-gray-300 py-2">Tulipe jaune</td>
                    <td class="border-b border-gray-300 py-2">15€</td>
                    <td class="border-b border-gray-300 py-2">3</td>
                    <td class="border-b border-gray-300 py-2">45€</td>
                </tr>
            </tbody>
        </table>
        <div class="flex justify-end mt-8">
            <p class="text-lg font-bold">Total : 115€</p>
        </div>
        <div class="flex justify-end mt-8">
            <a href="#"
                class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Payer</a>
        </div>
    </section>

</body>

</html>