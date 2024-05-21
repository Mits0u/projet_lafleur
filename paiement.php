<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaFleur | Paiement</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/35413ab60a.js" crossorigin="anonymous"></script>
    <style>
        body {
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-gray-200">

    <?php include 'navbar.php'; ?>

    <div class="max-w-lg mx-auto bg-white shadow-md rounded-lg overflow-hidden mt-16">
        <div class="px-6 py-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Paiement</h2>
            <form action="#" method="POST" id="payment-form" class="space-y-4">
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-600">Montant à payer</label>
                    <input type="text" id="amount" name="amount" class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500" readonly>
                </div>
                <div>
                    <label for="card-number" class="block text-sm font-medium text-gray-600">Numéro de carte</label>
                    <input type="text" id="card-number" name="card-number" class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500" pattern="\d{16}" maxlength="16" required>
                </div>
                <div class="flex justify-between">
                    <div class="w-1/2 mr-2">
                        <label for="expiry-date" class="block text-sm font-medium text-gray-600">Date d'expiration (MM/YY)</label>
                        <input type="text" id="expiry-date" name="expiry-date" class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500" pattern="(0[1-9]|1[0-2])\/?([0-9]{2})" maxlength="5" required>
                    </div>
                    <div class="w-1/2 ml-2">
                        <label for="cvv" class="block text-sm font-medium text-gray-600">CVV</label>
                        <input type="text" id="cvv" name="cvv" class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500" pattern="\d{3,4}" maxlength="4" required>
                    </div>
                </div>
                <div>
                    <button type="submit" id="pay-button" class="w-full px-4 py-2 text-lg font-semibold text-white bg-green-500 rounded-lg hover:bg-green-600 focus:outline-none focus:bg-green-600">Payer</button>
                </div>
            </form>
            <p id="payment-status" class="mt-4 text-center"></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const amountInput = document.getElementById('amount');
            const paymentForm = document.getElementById('payment-form');
            const paymentStatus = document.getElementById('payment-status');

            fetch('panier.php?action=total')
                .then(response => response.json())
                .then(data => {
                    amountInput.value = data.totalPrice + '€';
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération du prix total du panier :', error);
                });

            paymentForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const cardNumber = document.getElementById('card-number').value;
                const expiryDate = document.getElementById('expiry-date').value;
                const cvv = document.getElementById('cvv').value;

                if (validateCardNumber(cardNumber) && validateExpiryDate(expiryDate) && validateCVV(cvv)) {
                    paymentStatus.textContent = "Paiement validé !";
                } else {
                    paymentStatus.textContent = "Veuillez saisir des informations de carte valides.";
                }
            });

            function validateCardNumber(cardNumber) {
                let sum = 0;
                let double = false;
                for (let i = cardNumber.length - 1; i >= 0; i--) {
                    let digit = parseInt(cardNumber.charAt(i), 10);
                    if (double) {
                        digit *= 2;
                        if (digit > 9) digit -= 9;
                    }
                    sum += digit;
                    double = !double;
                }
                return (sum % 10) === 0;
            }

            function validateExpiryDate(expiryDate) {
                const today = new Date();
                const parts = expiryDate.split('/');
                const month = parseInt(parts[0], 10);
                const year = parseInt(parts[1], 10) + 2000;
                return (year > today.getFullYear() || (year === today.getFullYear() && month > today.getMonth() + 1));
            }

            function validateCVV(cvv) {
                return /^\d{3,4}$/.test(cvv);
            }
        });
    </script>

</body>

</html>