<?php
session_start();
?>

<script src="cart.js"></script>

<nav class="bg-white p-6 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <a class="text-lg font-bold text-gray-800" href="#">LaFleur</a>
        <div class="flex space-x-4">
            <a class="text-gray-600 hover:text-gray-800" href="index.php">Accueil</a>
            <a class="text-gray-600 hover:text-gray-800" href="#">Produits</a>
            <a class="text-gray-600 hover:text-gray-800" href="#">À propos</a>
            <a class="text-gray-600 hover:text-gray-800" href="#">Contact</a>
            <a class="text-gray-600 hover:text-gray-800" id="cart-icon"><i
                    class="fas fa-shopping-cart text-gray-800"></i></a>
            <?php if (isset($_SESSION['user'])): ?>
                <a class="text-gray-600 hover:text-gray-800" href="profile.php"><i
                        class="fas fa-user text-gray-800"></i></a>
                <a class="text-gray-600 hover:text-gray-800" href="logout.php"><i
                        class="fas fa-sign-out-alt text-gray-800"></i></a>
            <?php else: ?>
                <a class="text-gray-600 hover:text-gray-800" href="login.php"><i
                        class="fas fa-sign-in-alt text-gray-800"></i></a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div id="cart-popover" class="hidden bg-white p-8 absolute top-0 right-4 mt-16 shadow-md rounded-md justify-start">
</div>

<script src="https://kit.fontawesome.com/35413ab60a.js" crossorigin="anonymous"></script>