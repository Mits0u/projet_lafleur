<?php
    include './config/database.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_confirmation = $_POST['password_confirmation'];
        $date_creation = new DateTime('now');

        if ($password === $password_confirmation) {
            $query = $conn->prepare('INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, date_creation) VALUES (:name, :lastname, :email, :password, :date_creation)');
            $query->execute([
                'name' => $name,
                'lastname' => $lastname,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'date_creation' => $date_creation->format('Y-m-d H:i:s')
            ]);

            header('Location: index.php');
        }
    }
    ?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaFleur | Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/35413ab60a.js" crossorigin="anonymous"></script>
    <style>
        body {
            overflow: hidden;
        }
    </style>
</head>
<body>

    <?php include 'navbar.php'; ?>

    <section class="container mx-auto mt-16">
        <h2 class="text-2xl font-bold text-center">Inscription</h2>
        <form action="inscription.php" method="POST" class="max-w-md mx-auto mt-8">
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-bold mb-2">Nom</label>
                        <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="mb-4">
                        <label for="lastname" class="block text-gray-700 font-bold mb-2">Prénom</label>
                        <input type="text" name="lastname" id="lastname" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Adresse email</label>
                <input type="email" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-bold mb-2">Mot de passe</label>
                <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">S'inscrire</button>
                <a href="login.php" class="inline-block align-baseline font-bold text-sm text-green-500 hover:text-green-800">Déjà un compte ?</a>
            </div>
        </form>
    </section>
    
</body>
</html>