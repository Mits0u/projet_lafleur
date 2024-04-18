<?php session_start(); ?>


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

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <?php include 'navbar.php'; ?>

    <section class="bg-cover bg-center h-screen flex items-center"
        style="background-image: url('https://source.unsplash.com/1600x900/?flowers')">
        <div class="container mx-auto text-center text-inherit">
            <h1 class="text-4xl md:text-6xl font-bold">Bienvenue chez LaFleur</h1>
            <p class="text-lg md:text-xl mt-4 font-bold">Découvrez notre sélection de fleurs fraîches et magnifiques</p>
            <a href="#"
                class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 mt-6 inline-block rounded-full">Voir la sélection</a>
    </section>

</body>

</html>