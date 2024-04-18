<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaFleur | Compte</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/35413ab60a.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <section class="container mx-auto mt-16">
        <h2 class="text-2xl font-bold">Compte</h2>
        <h3 class="text-lg font-bold gap-8 mt-8">Informations personnelles:</h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="flex flex-col">
                <div class="mt-4">
                    <label class="block text-sm text-gray-600" id="for=" name">Nom</label>
                    <input type="text" class="w-full border border-gray-300 rounded-md py-2 px-4 mt-2 mr-4 focus:outline-none focus:ring focus:border-blue-300" id="name" name="name" value="">
                </div>
            </div>
            <div class="flex flex-col">
                <div class="mt-4">
                    <label class="block text-sm text-gray-600" id="for=" lastname">Prénom</label>
                    <input type="text" class="w-full border border-gray-300 rounded-md py-2 px-4 mt-2 focus:outline-none focus:ring focus:border-blue-300 gap-8" id="lastname" name="lastname" value=""> 
                </div>
            </div>
        </div>
        <div class="flex flex-col">
                <div class="mt-4">
                    <label class="block text-sm text-gray-600" id="for=" email">Email</label>
                    <input type="email" class="w-full border border-gray-300 rounded-md py-2 px-4 mt-2 focus:outline-none focus:ring focus:border-blue-300" id="email" name="email" value="">
                </div>
            </div>
        <h3 class="text-lg font-bold gap-8 mt-8">Adresse de livraison:</h3>
        <div class="grid grid-cols-3 gap-4">
            <div class="flex flex-col">
                <div class="mt-4">
                    <label class="block text-sm text-gray-600" id="for=" address">Adresse</label>
                    <input type="text" class="w-full border border-gray-300 rounded-md py-2 px-4 mt-2 mr-4 focus:outline-none focus:ring focus:border-blue-300" id="address" name="address" value="">
                </div>
            </div>
            <div class="flex flex-col">
                <div class="mt-4">
                    <label class="block text-sm text-gray-600" id="for=" city">Ville</label>
                    <input type="text" class="w-full border border-gray-300 rounded-md py-2 px-4 mt-2 focus:outline-none focus:ring focus:border-blue-300 gap-8" id="city" name="city" value=""> 
                </div>
            </div>
            <div class="flex flex-col">
                <div class="mt-4">
                    <label class="block text-sm text-gray-600" id="for=" zip">Code postal</label>
                    <input type="text" class="w-full border border-gray-300 rounded-md py-2 px-4 mt-2 focus:outline-none focus:ring focus:border-blue-300" id="zip" name="zip" value="">
                </div>
            </div>
        </div>
        <h3 class="text-lg font-bold gap-8 mt-8">Mot de passe:</h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="flex flex-col">
                <div class="mt-4">
                    <label class="block text-sm text-gray-600" id="for=" password">Nouveau mot de passe</label>
                    <input type="password" class="w-full border border-gray-300 rounded-md py-2 px-4 mt-2 mr-4 focus:outline-none focus:ring focus:border-blue-300" id="password" name="password" value="">
                </div>
            </div>
            <div class="flex flex-col">
                <div class="mt-4">
                    <label class="block text-sm text-gray-600" id="for=" password_confirm">Confirmer le mot de passe</label>
                    <input type="password" class="w-full border border-gray-300 rounded-md py-2 px-4 mt-2 focus:outline-none focus:ring focus:border-blue-300 gap-8" id="password_confirm" name="password_confirm" value=""> 
                </div>
            </div>
        </div>
        <div class="flex justify-end mt-8">
            <a href="#"
                class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Enregistrer</a>
        </div>
    </section>

</body>

</html>
