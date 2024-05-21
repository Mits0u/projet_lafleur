<?php

session_start();

include 'navbar.php';
include './config/database.php';

// Récupération de l'ID depuis la requête GET
$id = isset($_GET['id']) ? $_GET['id'] : null;

$result = null;
if ($id) {
    // Sélection des données de l'utilisateur avec l'ID spécifié
    $sql = "SELECT * FROM utilisateur WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['submit'])) {
    // Vérification et récupération des valeurs du formulaire
    $nom = isset($_POST['nom']) ? $_POST['nom'] : null;
    $type_compte_id = isset($_POST['type_compte_id']) ? $_POST['type_compte_id'] : null;
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $adresse = isset($_POST['adresse']) ? $_POST['adresse'] : null;
    $code_postal = isset($_POST['code_postal']) ? $_POST['code_postal'] : null;
    $ville = isset($_POST['ville']) ? $_POST['ville'] : null;

    // Exécution de la commande UPDATE pour mettre à jour le nom de l'utilisateur
    if ($nom && $id) {
        $sql = "UPDATE utilisateur SET type_compte_id = :type_compte_id ,nom = :nom, prenom = :prenom, email = :email, adresse = :adresse, code_postal = :code_postal, ville = :ville WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->bindParam(':type_compte_id', $type_compte_id, PDO::PARAM_STR);
        $query->bindParam(':nom', $nom, PDO::PARAM_STR);
        $query->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':adresse', $adresse, PDO::PARAM_STR);
        $query->bindParam(':code_postal', $code_postal, PDO::PARAM_INT);
        $query->bindParam(':ville', $ville, PDO::PARAM_STR);
        $query->execute();

        // Redirection vers back.php après la mise à jour
        header('Location: backend.php');
        exit;
    } else {
        echo "Erreur: Veuillez fournir un nom valide.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/35413ab60a.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-200">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-4">Modifier un utilisateur</h1>
        <form method="post" action="modifier_utilisateur.php?id=<?php echo $id; ?>">
            <div class="flex flex-col mb-4">
                <label class="mb-2 font-semibold" for="nom">Nom</label>
                <input class="border border-gray-300 p-4 rounded-md" type="text" name="nom" id="nom"
                    value="<?php echo isset($result['nom']) ? $result['nom'] : ''; ?>">
            </div>
            <div class="flex flex-col mb-4">
                <label class="mb-2 font-semibold" for="type_compte_id">Type_compte_id</label>
                <input class="border border-gray-300 p-4 rounded-md" type="text" name="type_compte_id" id="type_compte_id"
                    value="<?php echo isset($result['type_compte_id']) ? $result['type_compte_id'] : ''; ?>">
            </div>
            <div class="flex flex-col mb-4">
                <label class="mb-2 font-semibold" for="prenom">Prenom</label>
                <input class="border border-gray-300 p-4 rounded-md" type="text" name="prenom" id="prenom"
                    value="<?php echo isset($result['prenom']) ? $result['prenom'] : ''; ?>">
            </div>

            <div class="flex flex-col mb-4">
                <label class="mb-2 font-semibold" for="email">Email</label>
                <input class="border border-gray-300 p-4 rounded-md" type="text" name="email" id="email"
                    value="<?php echo isset($result['email']) ? $result['email'] : ''; ?>">
            </div>
            <div class="flex flex-col mb-4">
                <label class="mb-2 font-semibold" for="adresse">Adresse</label>
                <input class="border border-gray-300 p-4 rounded-md" type="text" name="adresse" id="adresse"
                    value="<?php echo isset($result['adresse']) ? $result['adresse'] : ''; ?>">
            </div>
            <div class="flex flex-col mb-4">
                <label class="mb-2 font-semibold" for="code_postal">Code postal</label>
                <input class="border border-gray-300 p-4 rounded-md" type="text" name="code_postal" id="code_postal"
                    value="<?php echo isset($result['code_postal']) ? $result['code_postal'] : ''; ?>">
            </div>
            <div class="flex flex-col mb-4">
                <label class="mb-2 font-semibold" for="ville">Ville</label>
                <input class="border border-gray-300 p-4 rounded-md" type="text" name="ville" id="ville"
                    value="<?php echo isset($result['ville']) ? $result['ville'] : ''; ?>">
            </div>
            <div class="flex flex-col md:flex-row gap-4 mt-4">
                <button class="bg-green-500v text-white w-full p-4 rounded-md" type="submit"
                    name="submit">Modifier</button>
            </div>
    </div>

    </form>

    </div>
</body>

</html>