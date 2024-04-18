<?php session_start(); ?>

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

    <?php
    include 'navbar.php';
    include './config/database.php';

    $user = $_SESSION['user'];
    $query = $conn->prepare('SELECT * FROM utilisateur WHERE id = :id');
    $query->execute(['id' => $user['id']]);
    $user = $query->fetch();

    $errors = []; // Variable pour stocker les messages d'erreur
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_id = $_SESSION['user']['id'];

        $nom = $_POST['name'];
        $prenom = $_POST['lastname'];
        $email = $_POST['email'];
        $adresse = $_POST['address'];
        $ville = $_POST['city'];
        $code_postal = $_POST['zip'];
        $nouveau_mot_de_passe = $_POST['password'];
        $confirmation_mot_de_passe = $_POST['password_confirm'];

        if (empty($nom)) {
            $errors['name'] = "Le champ nom est requis.";
        }

        if (empty($prenom)) {
            $errors['lastname'] = "Le champ prénom est requis.";
        }

        if (empty($email)) {
            $errors['email'] = "Le champ email est requis.";
        }

        if (empty($adresse)) {
            $errors['address'] = "Le champ adresse est requis.";
        }

        if (empty($ville)) {
            $errors['city'] = "Le champ ville est requis.";
        }

        if (empty($code_postal)) {
            $errors['zip'] = "Le champ code postal est requis.";
        }

        if (!empty($nouveau_mot_de_passe) && $nouveau_mot_de_passe !== $confirmation_mot_de_passe) {
            $errors['password'] = "Les mots de passe ne correspondent pas.";
        }


        if (empty($errors)) {
            $query = $conn->prepare('UPDATE utilisateur SET nom = :nom, prenom = :prenom, email = :email, adresse = :adresse, ville = :ville, code_postal = :code_postal WHERE id = :id');
            $query->execute(['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'adresse' => $adresse, 'ville' => $ville, 'code_postal' => $code_postal, 'id' => $user_id]);

            if (!empty($nouveau_mot_de_passe) && $nouveau_mot_de_passe === $confirmation_mot_de_passe) {
                $hashed_password = password_hash($nouveau_mot_de_passe, PASSWORD_DEFAULT);
                $query = $conn->prepare('UPDATE utilisateur SET mot_de_passe = :mot_de_passe WHERE id = :id');
                $query->execute(['mot_de_passe' => $hashed_password, 'id' => $user_id]);
            } elseif (!empty($nouveau_mot_de_passe) && $nouveau_mot_de_passe !== $confirmation_mot_de_passe) {
                $errors['password'] = "Les mots de passe ne correspondent pas.";
            }

            header("Location: profile.php?success=true");
            exit();
        }
    }
    ?>

    <section class="container mx-auto mt-16">
        <h2 class="text-2xl font-bold">Compte</h2>
        <h3 class="text-lg font-bold gap-8 mt-8">Informations personnelles:</h3>
        <form action="profile.php" method="POST">
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col">
                    <div class="mt-4">
                        <label class="block text-sm text-gray-600" id="for=" name">Nom</label>
                        <?php
                        echo '<input type="text" class="w-full border border-gray-300 rounded-md py-2 px-4 mt-2 mr-4 focus:outline-none focus:ring focus:border-blue-300" id="name" name="name" value="' . $user['nom'] . '">';
                        if (isset($errors['name'])) {
                            echo '<p class="text-red-500 text-xs italic">' . $errors['name'] . '</p>';
                        }
                        ?>
                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="mt-4">
                        <label class="block text-sm text-gray-600" id="for=" lastname">Prénom</label>
                        <?php
                        echo '<input type="text" class="w-full border border-gray-300 rounded-md py-2 px-4 mt-2 focus:outline-none focus:ring focus:border-blue-300" id="lastname" name="lastname" value="' . $user['prenom'] . '">';
                        if (isset($errors['lastname'])) {
                            echo '<p class="text-red-500 text-xs italic">' . $errors['lastname'] . '</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="flex flex-col">
                <div class="mt-4">
                    <label class="block text-sm text-gray-600" id="for=" email">Email</label>
                    <?php
                    echo '<input type="email" class="w-full border border-gray-300 rounded-md py-2 px-4 mt-2 mr-4 focus:outline-none focus:ring focus:border-blue-300" id="email" name="email" value="' . $user['email'] . '">';
                    if (isset($errors['email'])) {
                        echo '<p class="text-red-500 text-xs italic">' . $errors['email'] . '</p>';
                    }
                    ?>
                </div>
            </div>
            <h3 class="text-lg font-bold gap-8 mt-8">Adresse de livraison:</h3>
            <div class="grid grid-cols-3 gap-4">
                <div class="flex flex-col">
                    <div class="mt-4">
                        <label class="block text-sm text-gray-600" id="for=" address">Adresse</label>
                        <?php
                        echo '<input type="text" class="w-full border border-gray-300 rounded-md py-2 px-4 mt-2 mr-4 focus:outline-none focus:ring focus:border-blue-300" id="address" name="address" value="' . $user['adresse'] . '">';
                        if (isset($errors['address'])) {
                            echo '<p class="text-red-500 text-xs italic">' . $errors['address'] . '</p>';
                        }
                        ?>
                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="mt-4">
                        <label class="block text-sm text-gray-600" id="for=" city">Ville</label>
                        <?php
                        echo '<input type="text" class="w-full border border-gray-300 rounded-md py-2 px-4 mt-2 focus:outline-none focus:ring focus:border-blue-300" id="city" name="city" value="' . $user['ville'] . '">';
                        if (isset($errors['city'])) {
                            echo '<p class="text-red-500 text-xs italic">' . $errors['city'] . '</p>';
                        }
                        ?>
                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="mt-4">
                        <label class="block text-sm text-gray-600" id="for=" zip">Code postal</label>
                        <?php
                        echo '<input type="text" class="w-full border border-gray-300 rounded-md py-2 px-4 mt-2 focus:outline-none focus:ring focus:border-blue-300" id="zip" name="zip" value="' . $user['code_postal'] . '">';
                        if (isset($errors['zip'])) {
                            echo '<p class="text-red-500 text-xs italic">' . $errors['zip'] . '</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <h3 class="text-lg font-bold gap-8 mt-8">Mot de passe:</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col">
                    <div class="mt-4">
                        <label class="block text-sm text-gray-600" id="for=" password">Nouveau mot de passe</label>
                        <input type="password"
                            class="w-full border border-gray-300 rounded-md py-2 px-4 mt-2 mr-4 focus:outline-none focus:ring focus:border-blue-300"
                            id="password" name="password" value="" placeholder="facultatif">
                        <?php
                        if (isset($errors['password'])) {
                            echo '<p class="text-red-500 text-xs italic">' . $errors['password'] . '</p>';
                        }
                        ?>
                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="mt-4">
                        <label class="block text-sm text-gray-600" id="for=" password_confirm">Confirmer le mot de
                            passe</label>
                        <input type="password"
                            class="w-full border border-gray-300 rounded-md py-2 px-4 mt-2 focus:outline-none focus:ring focus:border-blue-300 gap-8"
                            id="password_confirm" name="password_confirm" value="" placeholder="facultatif">
                        <?php
                        if (isset($errors['password'])) {
                            echo '<p class="text-red-500 text-xs italic">' . $errors['password'] . '</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="flex justify-end mt-8">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Enregistrer</button>
            </div>
        </form>

        <?php
        if (isset($_GET['success'])) {
            echo '<div class="mt-8 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Succès!</strong>
            <span class="block sm:inline">Vos informations ont été mises à jour.</span>
          </div>';
        }
        ?>
    </section>

</body>

</html>