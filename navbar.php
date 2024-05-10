<script src="assets/js/cart.js"></script>

<nav class="bg-white p-6 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <a class="text-lg font-bold text-gray-800" href="index.php">LaFleur</a>
        <div class="hidden md:flex space-x-4">
            <a class="text-gray-600 hover:text-gray-800" href="index.php">Accueil</a>


            <a class="text-gray-600 hover:text-gray-800" href="produits.php">Produits</a>

            <a class="text-gray-600 hover:text-gray-800" href="contact.php">Contact</a>
            <a class="text-gray-600 hover:text-gray-800" href="panier.php"><i
                    class="fas fa-shopping-cart text-gray-800"></i></a>
            <?php if (isset($_SESSION['user'])): ?>
                <a class="text-gray-600 hover:text-gray-800" href="profile.php"><i
                        class="fas fa-user text-gray-800"></i></a>
                <a class="text-gray-600 hover:text-gray-800" href="deconnexion.php"><i
                        class="fas fa-sign-out-alt text-gray-800"></i></a>
            <?php else: ?>
                <a class="text-gray-600 hover:text-gray-800" href="connexion.php"><i
                        class="fas fa-sign-in-alt text-gray-800"></i></a>
            <?php endif; ?>
        </div>
        <div class="md:hidden flex">
            <button id="menu-toggle" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                <i class="fas fa-bars text-gray-800"></i>
            </button>
        </div>
    </div>
</nav>

<div id="mobile-menu"
    class="fixed top-0 right-0 w-64 h-full bg-white shadow-md transform translate-x-full transition-transform duration-300 ease-in-out z-50">
    <div class="p-4">
        <a class="block text-gray-600 hover:text-gray-800 py-2" href="index.php">Accueil</a>
        <a class="block text-gray-600 hover:text-gray-800 py-2" href="produits.php">Produits</a>
        <a class="block text-gray-600 hover:text-gray-800 py-2" href="contact.php">Contact</a>
        <a class="block text-gray-600 hover:text-gray-800 py-2" href="panier.php">Panier</a>
        <?php if (isset($_SESSION['user'])): ?>
            <a class="block text-gray-600 hover:text-gray-800 py-2" href="profile.php">Compte</a>
            <a class="block text-gray-600 hover:text-gray-800 py-2" href="deconnexion.php">Déconnexion</a>
        <?php else: ?>
            <a class="block text-gray-600 hover:text-gray-800 py-2" href="connexion.php">Connexion</a>
        <?php endif; ?>
    </div>
</div>

<div id="mobile-menu-overlay" class="fixed top-0 right-0 w-full h-full bg-black opacity-50 cursor-pointer z-40 hidden">
</div>
<div id="cart-popover" class="hidden bg-white p-8 absolute top-0 right-4 mt-16 shadow-md rounded-md justify-start">
</div>

<script>
    document.getElementById('menu-toggle').addEventListener('click', function () {
        var menu = document.getElementById('mobile-menu');
        var overlay = document.getElementById('mobile-menu-overlay');
        if (menu.classList.contains('translate-x-full')) {
            menu.classList.remove('translate-x-full');
            overlay.classList.remove('hidden');
        } else {
            menu.classList.add('translate-x-full');
            overlay.classList.add('hidden');
        }
    });

    document.getElementById('mobile-menu-overlay').addEventListener('click', function () {
        var menu = document.getElementById('mobile-menu');
        var overlay = document.getElementById('mobile-menu-overlay');
        menu.classList.add('translate-x-full');
        overlay.classList.add('hidden');
    });
</script>