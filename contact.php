<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaFleur | Nous contacter</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/35413ab60a.js" crossorigin="anonymous"></script>
    <style>
        .contact-card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .contact-card .icon {
            background-color: #4CAF50;
            color: #ffffff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            margin-right: 15px;
        }
    </style>
</head>

<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>
    <div class="container mx-auto mt-16 p-8">
        <h1 class="text-4xl font-bold text-center mb-8">Nous contacter</h1>
        <div class="flex flex-wrap">
            <!-- Informations de contact -->
            <div class="w-full lg:w-1/3 px-4 flex flex-col justify-center mb-4">
                <div class="contact-card">
                    <div class="flex items-center mb-4">
                        <div class="icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <span class="text-lg">Numéro de téléphone: 0123 456 789</span>
                    </div>
                    <div class="flex items-center mb-4">
                        <div class="icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <span class="text-lg">Adresse: 123 Rue des Fleurs, 75000 Paris</span>
                    </div>
                    <div class="flex items-center">
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <span class="text-lg">Horaires d'ouverture: Lun-Dim: 9h00 - 18h00</span>
                    </div>
                </div>
            </div>
            <!-- Formulaire de contact -->
            <div class="w-full lg:w-2/3 px-4">
                <div class="contact-card">
                    <form action="#" method="post" class="space-y-4">
                        <div>
                            <label for="name" class="block text-lg font-medium">Nom</label>
                            <input type="text" id="name" name="name" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500" placeholder="Entrez votre nom">
                        </div>
                        <div>
                            <label for="email" class="block text-lg font-medium">Email</label>
                            <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500" placeholder="Entrez votre email">
                        </div>
                        <div>
                            <label for="message" class="block text-lg font-medium">Message</label>
                            <textarea id="message" name="message" rows="5" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500" placeholder="Entrez votre message"></textarea>
                        </div>
                        <div>
                            <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 transition duration-200">Envoyer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
