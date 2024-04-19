// document.addEventListener("DOMContentLoaded", function () {
//     const cartIcon = document.getElementById('cart-icon');
//     const cartPopover = document.getElementById('cart-popover');

//     cartIcon.addEventListener('click', function (event) {
//         event.preventDefault();
//         cartPopover.classList.toggle('hidden');

//         const xhr = new XMLHttpRequest();
//         xhr.onreadystatechange = function () {
//             if (xhr.readyState === XMLHttpRequest.DONE) {
//                 if (xhr.status === 200) {
//                     const responseData = JSON.parse(xhr.responseText);
//                     if (responseData.error) {
//                         renderMessage(responseData.error);
//                     } else if (responseData.message) {
//                         renderMessage(responseData.message);
//                     } else {
//                         renderCart(responseData);
//                     }
//                 } else {
//                     console.error('Une erreur est survenue lors de la récupération du panier.');
//                 }
//             }
//         };
//         xhr.open('GET', 'get_cart.php', true);
//         xhr.send();
//     });

//     document.addEventListener('click', function (event) {
//         if (!cartPopover.contains(event.target) && !cartIcon.contains(event.target)) {
//             cartPopover.classList.add('hidden');
//         }
//     });

//     // Gestion des événements pour diminuer ou augmenter la quantité
//     cartPopover.addEventListener('click', function (event) {
//         const target = event.target;
//         if (target.classList.contains('decrease') || target.classList.contains('increase')) {
//             const productId = target.dataset.productId;
//             const quantityChange = target.classList.contains('decrease') ? -1 : +1;
//             updateCart(productId, quantityChange);
//         }
//     });

//     function updateCart(productId, quantityChange) {
//         console.log("Updating cart with productId:", productId, "and quantityChange:", quantityChange);
//         const xhr = new XMLHttpRequest();
//         xhr.onreadystatechange = function () {
//             if (xhr.readyState === XMLHttpRequest.DONE) {
//                 console.log("Response from server:", xhr.responseText);
//                 if (xhr.status === 200) {
//                     const responseData = JSON.parse(xhr.responseText);
//                     if (responseData.error) {
//                         console.error(responseData.error);
//                     } else {
//                         renderCart(responseData);
//                     }
//                     fetchCartData();
//                 } else {
//                     console.error('Une erreur est survenue lors de la mise à jour du panier.');
//                 }
//             }
//         };
//         xhr.open('POST', 'update_cart.php', true);
//         xhr.setRequestHeader('Content-Type', 'application/json');
//         xhr.send(JSON.stringify({ productId: productId, quantityChange: quantityChange }));
//     }


//     function renderCart(cartData) {
//         console.log("Rendering cart with data:", cartData);
//         cartPopover.innerHTML = `
//             <h2 class="text-lg font-semibold mb-4">Votre panier</h2>
//             <ul>
//                 ${cartData.products.map(product => `
//                     <li class="flex items-center py-4 border-b border-gray-200">
//                         <img src="data:image/jpeg;base64,${product.image}" alt="${product.name}" class="w-16 h-16 object-cover rounded-full mr-4">
//                         <div class="flex-grow">
//                             <p class="text-gray-800">${product.name}</p>
//                             <p class="text-gray-600">${product.price}€</p>
//                         </div>
//                         <div class="flex items-center">
//                             <button class="text-gray-500 hover:text-gray-600 focus:outline-none"><i class="fas fa-minus decrease" data-product-id="${product.id}"></i></button>
//                             <span class="mx-2">${product.quantity}</span>
//                             <button class="text-gray-500 hover:text-gray-600 focus:outline-none"><i class="fas fa-plus increase" data-product-id="${product.id}"></i></button>
//                     </li>
//                 `).join('')}
//             </ul>
//             <p class="mt-4 text-lg font-semibold text-gray-800">Total : ${cartData.total}€</p>
//             <a href="cart.php" class="block mt-4 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Passer la commande</a>
//         `;
//     }

//     function fetchCartData() {
//         const xhr = new XMLHttpRequest();
//         xhr.onreadystatechange = function () {
//             if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
//                 const responseData = JSON.parse(xhr.responseText);
//                 renderCart(responseData); // Affichage des données du panier mises à jour
//             }
//         };
//         xhr.open('GET', 'get_cart.php', true);
//         xhr.send();
//     }

//     function renderMessage(message) {
//         cartPopover.innerHTML = `
//             <p class="text-lg font-semibold text-gray-800">${message}</p>
//         `;
//     }
// });
