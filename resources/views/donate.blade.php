<!doctype html>
<html lang="en">
<head>
    <x-head titre="Accueil" />
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>

<header>
    <x-header/>
</header>

<main>
    <form id="donation-form">
        @csrf
        <input type="text" id="name" name="name" required placeholder="Name">
        <input type="email" id="email" name="email" required placeholder="Email">
        <input type="number" id="amount" name="amount" required placeholder="Donation Amount">
        <div id="card-element"></div>
        <div id="card-errors" role="alert"></div>
        <button type="submit">Donate</button>
    </form>
    <div id="result-message"></div>

    <script>
        var stripe = Stripe('pk_test_51Q2owfB3dTrJX9EwFg8HTocUFxsOjtBgXzsh2OUofv08XonDpoyM7K858o0x7lIKIlZbafVtSWe7He8KFw6gGNvU00Q8ovekhT');
        var elements = stripe.elements();
        var card = elements.create('card');
        card.mount('#card-element');

        var form = document.getElementById('donation-form');
        var resultMessage = document.getElementById('result-message');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            var form = document.getElementById('donation-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            var formData = new FormData(form);
            fetch('{{ route('donate.process') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        resultMessage.textContent = `${data.message} Charge ID: ${data.charge_id}, Amount: $${data.amount}`;
                        form.reset();
                    } else {
                        resultMessage.textContent = `Error: ${data.message}`;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    resultMessage.textContent = 'An error occurred. Please try again.';
                });
        }
    </script>
</main>

<footer>
    <x-footer/>
</footer>

</body>
</html>
