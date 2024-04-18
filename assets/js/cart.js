
document.addEventListener("DOMContentLoaded", function () {
    const cartIcon = document.getElementById('cart-icon');
    const cartPopover = document.getElementById('cart-popover');

    cartIcon.addEventListener('click', function (event) {
        event.preventDefault();
        cartPopover.classList.toggle('hidden');

        const cartProducts = [
            { name: 'Rose rouge', price: 20.99, quantity: 2, img: 'https://source.unsplash.com/1600x900/?rose' },
            { name: 'Lys blanc', price: 25.99, quantity: 1, img: 'https://source.unsplash.com/1600x900/?lily' },
            { name: 'Tulipe jaune', price: 15.99, quantity: 3, img: 'https://source.unsplash.com/1600x900/?tulip' },
        ];

        cartPopover.innerHTML = `
        <h2 class="text-lg font-semibold mb-4">Votre panier</h2>
        <ul>
            ${cartProducts.map(product => `
                <li class="flex items-center py-4 border-b border-gray-200">
                    <img src="${product.img}" alt="${product.name}" class="w-16 h-16 object-cover rounded-full mr-4">                            
                    <div class="flex-grow">
                        <p class="text-gray-800">${product.name}</p>
                        <p class="text-gray-600">${product.price}€</p>
                    </div>
                    <div class="flex items-center">
                        <button class="text-gray-500 hover:text-gray-600 focus:outline-none"><i class="fas fa-minus"></i></button>
                        <span class="mx-2">${product.quantity}</span>
                        <button class="text-gray-500 hover:text-gray-600 focus:outline-none"><i class="fas fa-plus"></i></button>
                    </div>
                </li>
            `).join('')}
        </ul>
        <p class="mt-4 text-lg font-semibold text-gray-800">Total : ${cartProducts.reduce((acc, product) => acc + product.price, 0)}€</p>
        <a href="cart.php" class="block mt-4 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Passer la commande</a>
    `;
    
    });

    document.addEventListener('click', function (event) {
        if (!cartPopover.contains(event.target) && !cartIcon.contains(event.target)) {
            cartPopover.classList.add('hidden');
        }
    });
});
