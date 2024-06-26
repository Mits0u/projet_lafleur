<?php
session_start();

$error_message = '';

include './config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = $conn->prepare('SELECT * FROM utilisateur WHERE email = :email');
    $query->execute(['email' => $email]);
    $user = $query->fetch();

    if ($user) {
        if (password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['user'] = $user;
            header('Location: index.php');
            exit;
        } else {
            $error_message = 'Mot de passe incorrect';
        }
    } else {
        $error_message = 'Aucun utilisateur trouvé avec cet e-mail';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaFleur | Connexion</title>
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
        <h2 class="text-2xl font-bold text-center">Connexion</h2>
        <form action="connexion.php" method="POST" class="max-w-md mx-auto mt-8">
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Adresse email</label>
                <input type="email" name="email" id="email"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <?php if ($error_message === 'Aucun utilisateur trouvé avec cet e-mail'): ?>
                    <p class="text-red-500 text-xs italic"><?php echo $error_message; ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-bold mb-2">Mot de passe</label>
                <input type="password" name="password" id="password"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <?php if ($error_message === 'Mot de passe incorrect'): ?>
                    <p class="text-red-500 text-xs italic"><?php echo $error_message; ?></p>
                <?php endif; ?>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Se
                    connecter</button>
                <a href="inscription.php"
                    class="inline-block align-baseline font-bold text-sm text-green-500 hover:text-green-800">Pas encore
                    de compte ?</a>
            </div>
        </form>
    </section>

</body>

</html>