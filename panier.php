<?php
session_start();
include './config/database.php';

function getCartItems()
{
    include './config/database.php';

    if (!isset($_SESSION['user'])) {
        return [];
    }

    $userId = $_SESSION['user']['id'];

    $query = $conn->prepare('SELECT DISTINCT f.id, f.nom, f.prix, f.image, jpf.quantite, (f.prix * jpf.quantite) AS total
    FROM fleur f
    INNER JOIN junction_panier_fleur jpf ON f.id = jpf.id_fleur
    INNER JOIN panier p ON jpf.id_panier = p.id
    INNER JOIN commande c ON p.id = c.id_panier
    WHERE c.id_utilisateur = :userId');
    $query->bindParam(':userId', $userId);
    $query->execute();
    $cartItems = $query->fetchAll();

    return $cartItems;
}

function updateCartItemQuantity($productId, $quantity)
{
    include './config/database.php';

    $userId = $_SESSION['user']['id'];

    // Préparation de la requête SQL
    $query = $conn->prepare('UPDATE junction_panier_fleur jpf
                             INNER JOIN panier p ON jpf.id_panier = p.id
                             INNER JOIN commande c ON p.id = c.id_panier
                             SET jpf.quantite = :quantity
                             WHERE c.id_utilisateur = :userId AND jpf.id_fleur = :productId');
    $query->bindParam(':quantity', $quantity);
    $query->bindParam(':userId', $userId);
    $query->bindParam(':productId', $productId);

    // Exécution de la requête SQL
    $result = $query->execute();

    // Vérification du résultat de la mise à jour
    if ($result) {
        // Mise à jour réussie, renvoie la nouvelle quantité
        $newQuantity = intval($quantity); // Assure que la nouvelle quantité est un entier
        echo json_encode(['success' => true, 'newQuantity' => $newQuantity]);
        exit;
    } else {
        // Erreur lors de la mise à jour, renvoie un message d'erreur
        echo json_encode(['success' => false, 'error' => 'Erreur lors de la mise à jour de la quantité']);
        exit;
    }
}

function deleteCartItem($productId)
{
    include './config/database.php';

    $userId = $_SESSION['user']['id'];

    $deleteQuery = $conn->prepare('DELETE jpf FROM junction_panier_fleur jpf
                                   INNER JOIN panier p ON jpf.id_panier = p.id
                                   INNER JOIN commande c ON p.id = c.id_panier
                                   WHERE c.id_utilisateur = :userId AND jpf.id_fleur = :productId');
    $deleteQuery->bindParam(':userId', $userId);
    $deleteQuery->bindParam(':productId', $productId);
    $result = $deleteQuery->execute();

    if ($result) {
        echo json_encode(['success' => true]);
        exit;
    } else {
        echo json_encode(['success' => false]);
        exit;
    }
}

$action = $_GET['action'] ?? '';

if ($action === 'update') {
    $productId = $_GET['id'] ?? '';
    $quantity = $_GET['quantity'] ?? '';

    if ($productId !== '' && $quantity !== '') {
        updateCartItemQuantity($productId, $quantity);
    }
} elseif ($action === 'delete') {
    $productId = $_GET['id'] ?? '';

    if ($productId !== '') {
        deleteCartItem($productId);
    }
} elseif ($action === 'total') {
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
            <?php if (isset($_SESSION['user'])) : ?>
                <div class="rounded-lg md:w-2/3">
                    <?php foreach ($cartItems as $item) : ?>
                        <div class="justify-between mb-6 rounded-lg bg-white p-6 shadow-md sm:flex sm:justify-start" data-product-id="<?php echo $item['id']; ?>">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($item['image']); ?>" alt="<?php echo $item['nom']; ?>" class="w-24 h-24 object-cover rounded-lg" />

                            <div class="sm:ml-4 sm:flex sm:w-full sm:justify-between">
                                <div class="mt-5 sm:mt-0">
                                    <h2 class="text-lg font-bold text-gray-900"><?php echo $item['nom']; ?></h2>
                                </div>
                                <div class="mt-4 flex justify-between sm:space-y-6 sm:mt-0 sm:block sm:space-x-6">
                                    <div class="flex items-center border-gray-100">
                                        <span class="cursor-pointer rounded-l bg-gray-100 py-1 px-3.5 decrease-button duration-100 hover:bg-blue-500 hover:text-blue-50">-</span>
                                        <input class="h-8 w-8 border bg-white text-center text-xs outline-none" type="number" value="<?php echo $item['quantite']; ?>" min="1" data-product-id="<?php echo $item['id']; ?>" />
                                        <span class="cursor-pointer rounded-r bg-gray-100 py-1 px-3 increase-button duration-100 hover:bg-blue-500 hover:text-blue-50">+</span>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <p class="text-sm"><?php echo $item['prix']; ?></p>
                                        <a href="#" class="text-red-500"><i class="fas fa-trash delete-button" data-product-id="<?php echo $item['id']; ?>"></i></a>
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
                        <a href="#" class="block bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 mt-6 rounded-full">Payer</a>
                    </div>
                </div>
            <?php else : ?>
                <div class="text-center text-gray-600">
                    <p>Vous devez être connecté pour accéder à votre panier.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const totalPriceElement = document.getElementById('total-price');
            const quantityInputs = document.querySelectorAll('input[type="number"]');

            quantityInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const productId = this.dataset.productId;
                    const quantity = this.value;

                    fetch(`panier.php?action=update&id=${productId}&quantity=${quantity}`, {
                            method: 'POST'
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                updateTotalPrice();
                            } else {
                                console.error('Erreur lors de la mise à jour de la quantité');
                            }
                        })
                        .catch(error => {
                            console.error('Erreur lors de la mise à jour de la quantité :', error);
                        });
                });
            });

            function updateTotalPrice() {
                fetch('panier.php?action=total')
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
            button.addEventListener('click', function() {
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
            button.addEventListener('click', function() {
                const input = this.previousElementSibling;
                let quantity = parseInt(input.value);
                quantity++;
                input.value = quantity;
                input.dispatchEvent(new Event('change')); 
            });
        });

        const deleteButtons = document.querySelectorAll('.delete-button');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const productElement = document.querySelector(`div[data-product-id="${productId}"]`);

                fetch(`panier.php?action=delete&id=${productId}`, {
                        method: 'POST'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            productElement.remove();
                            updateTotalPrice();
                        } else {
                            console.error('Erreur lors de la suppression de l\'article');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors de la suppression de l\'article :', error);
                    });
            });
        });

        function updateTotalPrice() {
            fetch('panier.php?action=total')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('total-price').textContent = data.totalPrice + '€';
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération du prix total du panier :', error);
                });
        }
    </script>

</body>

</html>
