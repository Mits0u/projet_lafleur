<?php
session_start();
include './config/database.php';

function getCartItems()
{
    include './config/database.php';

    $userId = $_SESSION['user']['id'];

    $query = $conn->prepare('SELECT f.id, f.nom, f.prix, f.image, jpf.quantite, (f.prix * jpf.quantite) AS total
        FROM fleur f
        INNER JOIN junction_panier_fleur jpf ON f.id = jpf.id_fleur
        INNER JOIN panier p ON jpf.id_panier = p.id
        WHERE p.id = :userId');
    $query->bindParam(':userId', $userId);
    $query->execute();
    $cartItems = $query->fetchAll();

    return $cartItems;
}

function updateCartItemQuantity($productId, $quantity)
{
    include './config/database.php';

    $userId = $_SESSION['user']['id'];
    $query = $conn->prepare('UPDATE junction_panier_fleur SET quantite = :quantity WHERE id_panier = :userId AND id_fleur = :productId');
    $query->bindParam(':quantity', $quantity);
    $query->bindParam(':userId', $userId);
    $query->bindParam(':productId', $productId);
    $result = $query->execute();

    if ($result) {
        return [
            'success' => true,
            'message' => 'Quantité mise à jour avec succès.'
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Échec de la mise à jour de la quantité.'
        ];
    }
}

function deleteCartItem($productId)
{
    include './config/database.php';

    $userId = $_SESSION['user']['id'];
    
    // Supprimer les enregistrements dans la table panier_junction_panier_fleur
    $deletePanierJunctionQuery = $conn->prepare('DELETE FROM panier_junction_panier_fleur WHERE id_junction_panier_fleur IN (SELECT id FROM junction_panier_fleur WHERE id_panier = :userId)');
    $deletePanierJunctionQuery->bindParam(':userId', $userId);
    $deletePanierJunctionQuery->execute();
    
    // Supprimer les enregistrements dans la table fleur_junction_panier_fleur
    $deleteFleurJunctionQuery = $conn->prepare('DELETE FROM fleur_junction_panier_fleur WHERE id_junction_panier_fleur IN (SELECT id FROM junction_panier_fleur WHERE id_panier = :userId)');
    $deleteFleurJunctionQuery->bindParam(':userId', $userId);
    $deleteFleurJunctionQuery->execute();
    
    // Ensuite, supprimer l'entrée dans la table junction_panier_fleur
    $deleteJunctionQuery = $conn->prepare('DELETE FROM junction_panier_fleur WHERE id_panier = :userId');
    $deleteJunctionQuery->bindParam(':userId', $userId);
    $result = $deleteJunctionQuery->execute();

    if ($result) {
        return [
            'success' => true,
            'message' => 'Article supprimé avec succès.'
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Échec de la suppression de l\'article.'
        ];
    }
}


$action = $_GET['action'] ?? '';

if ($action === 'update') {
    $productId = $_GET['id'] ?? '';
    $quantity = $_GET['quantity'] ?? '';

    if ($productId !== '' && $quantity !== '') {
        header('Content-Type: application/json');
        echo json_encode(updateCartItemQuantity($productId, $quantity));
        exit;
    }
} elseif ($action === 'delete') {
    $productId = $_GET['id'] ?? '';

    if ($productId !== '') {
        header('Content-Type: application/json');
        echo json_encode(deleteCartItem($productId));
        exit;
    }
} elseif ($action === 'total') {
    // Calculez et renvoyez le prix total du panier
    $cartItems = getCartItems();
    $totalPrice = array_sum(array_column($cartItems, 'total'));
    header('Content-Type: application/json');
    echo json_encode(['totalPrice' => number_format($totalPrice, 2)]);
    exit;
}

$cartItems = getCartItems();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaFleur | Panier</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/35413ab60a.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100">

    <?php include 'navbar.php'; ?>

    <div class="h-screen bg-gray-100 pt-20">
        <h1 class="mb-10 text-center text-2xl font-bold">Panier</h1>
        <div class="mx-auto max-w-5xl justify-center px-6 md:flex md:space-x-6 xl:px-0">
            <div class="rounded-lg md:w-2/3">
                <?php foreach ($cartItems as $item): ?>
                    <div class="justify-between mb-6 rounded-lg bg-white p-6 shadow-md sm:flex sm:justify-start">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($item['image']); ?>"
                            alt="<?php echo $item['nom']; ?>" class="w-24 h-24 object-cover rounded-lg" />

                        <div class="sm:ml-4 sm:flex sm:w-full sm:justify-between">
                            <div class="mt-5 sm:mt-0">
                                <h2 class="text-lg font-bold text-gray-900"><?php echo $item['nom']; ?></h2>
                            </div>
                            <div class="mt-4 flex justify-between sm:space-y-6 sm:mt-0 sm:block sm:space-x-6">
                                <div class="flex items-center border-gray-100">
                                    <span
                                        class="cursor-pointer rounded-l bg-gray-100 py-1 px-3.5 decrease-button duration-100 hover:bg-blue-500 hover:text-blue-50">-</span>
                                    <input class="h-8 w-8 border bg-white text-center text-xs outline-none" type="number"
                                        value="<?php echo $item['quantite']; ?>" min="1"
                                        data-product-id="<?php echo $item['id']; ?>" />
                                    <span
                                        class="cursor-pointer rounded-r bg-gray-100 py-1 px-3 increase-button duration-100 hover:bg-blue-500 hover:text-blue-50">+</span>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <p class="text-sm"><?php echo $item['prix']; ?></p>
                                    <a href="cart.php?action=delete&id=<?php echo $item['id']; ?>" class="text-red-500"><i
                                            class="fas fa-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="rounded-lg md:w-1/3">
                <div class="bg-white p-6 shadow-md">
                    <h2 class="text-lg font-bold text-gray-900">Prix total</h2>
                    <div class="flex justify-between mt-4">
                        <p class="text-sm text-gray-600">Total</p>
                        <p id="total-price" class="text-sm text-gray-900">
                            <?php echo number_format(array_sum(array_column($cartItems, 'total')), 2) . '€'; ?>
                        </p>
                    </div>
                    <a href="#"
                        class="block bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 mt-6 rounded-full">Payer</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const totalPriceElement = document.getElementById('total-price');
            const quantityInputs = document.querySelectorAll('input[type="number"]');

            quantityInputs.forEach(input => {
                input.addEventListener('change', function () {
                    const productId = this.dataset.productId;
                    const quantity = this.value;

                    fetch(`cart.php?action=update&id=${productId}&quantity=${quantity}`, {
                        method: 'POST'
                    })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            // Mettre à jour le prix total du panier après la mise à jour de la quantité
                            updateTotalPrice();
                        })
                        .catch(error => {
                            console.error('Erreur lors de la mise à jour de la quantité :', error);
                        });
                });
            });

            // Fonction pour mettre à jour le prix total du panier
            function updateTotalPrice() {
                fetch('cart.php?action=total')
                    .then(response => response.json())
                    .then(data => {
                        totalPriceElement.textContent = data.totalPrice + '€';
                    })
                    .catch(error => {
                        console.error('Erreur lors de la récupération du prix total du panier :', error);
                    });
            }

            updateTotalPrice();
        });

        const decreaseButtons = document.querySelectorAll('.decrease-button');
        decreaseButtons.forEach(button => {
            button.addEventListener('click', function () {
                const input = this.nextElementSibling;
                let quantity = parseInt(input.value);
                if (quantity > 1) {
                    quantity--;
                    input.value = quantity;
                    input.dispatchEvent(new Event('change'));
                }
            });
        });

        const increaseButtons = document.querySelectorAll('.increase-button');
        increaseButtons.forEach(button => {
            button.addEventListener('click', function () {
                const input = this.previousElementSibling;
                let quantity = parseInt(input.value);
                quantity++;
                input.value = quantity;
                input.dispatchEvent(new Event('change'));
            });
        });

        const deleteButtons = document.querySelectorAll('.fa-trash');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.dataset.productId;

                fetch(`cart.php?action=delete&id=${productId}`, {
                    method: 'POST' // Utilisez la méthode POST pour envoyer les données
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        // Mettre à jour l'affichage si nécessaire
                    })
                    .catch(error => {
                        console.error('Erreur lors de la suppression de l\'article :', error);
                    });
            });
        });
    </script>

</body>

</html>