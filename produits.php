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

<body class="bg-gray-200 font-sans leading-normal tracking-normal">

    <?php include 'navbar.php'; ?>

    <section class="bg-cover bg-center h-screen flex  text-white"
        style="background-image: url('https://source.unsplash.com/1600x900/?flowers')">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl md:text-6xl font-bold">Nos produits </h1>

            <div class="flex items-center justify-center mt-24 gap-8">

                <a href="uniproduit.php">
                    <div class="flex flex-col sm:flex-row col-span-1 row-span-1 sm:hover:shadow-md rounded-md ">
                        <div class="card1  bg-white w-72 h-64 rounded-md sm:hover:shadow-lg text-black bg-white">
                            <div class="Photo flex justify-center">
                                <img src="https://source.unsplash.com/1600x900/?tulip" alt="photo"
                                    class="rounded-t-md ">
                            </div>

                            <div class="flex flex-col p-4">
                                <div class="flex justify-start">
                                    <h1 class="text-2xl font-bold">Tulipe</h1>
                                </div>
                                <div class="flex flex-row items-center gap-1">
                                    <p class="text-md">dès</p>
                                    <p class="text-lg font-bold "> 10€</p>
                                </div>

                            </div>


                        </div>
                    </div>
                </a>

            </div>
        </div>
    </section>

</body>

</html>