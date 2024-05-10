<?php session_start();

include 'navbar.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactez-nous</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/35413ab60a.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-200">

    <section class="container mx-auto bg-grey-950 flex mt-12 mb-12 flex-col">
        <div class="mt-16">
            <h1 class="text-4xl font-bold text-black">Contactez-nous :</h1>
            <form action="" method="POST" class="mt-6">
                <div class="flex flex-col md:flex-row md:gap-6 ">
                    <div class="mb-4 w-full">
                        <label for="nom" class="block text-gray-700 font-bold mb-2">Nom :</label>
                        <input type="text" id="nom" name="nom"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4 w-full">
                        <label for="prenom" class="block text-gray-700 font-bold mb-2">Prénom :</label>
                        <input type="text" id="prenom" name="prenom"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-bold mb-2">Email :</label>
                    <input type="email" id="email" name="email"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-6">
                    <label for="message" class="block text-gray-700 font-bold mb-2">Message :</label>
                    <textarea id="message" name="message" rows="5"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>
                <div class="flex items-center justify-end ">
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Envoyer</button>
                </div>
            </form>
        </div>
        <div>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['message'])) {
                    // Simuler un temps de chargement de 3 secondes
                    sleep(3);

                    echo "<p class='text-green-500 justify-center'>Votre message a été envoyé avec succès.</p>";
                } else {
                    echo "<p class='text-red-500 justify-center'>Veuillez remplir tous les champs du formulaire.</p>";
                }
            }
            ?>
        </div>
    </section>

</body>

</html>