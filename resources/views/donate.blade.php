<!doctype html>
<html lang="en">
<head>
    <x-head titre="Accueil"/>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>

<header>
    <x-header/>
</header>

<main>
    <div class="container">
        <div class="row my-5">
            <div class="col-lg-7 col-md-6 ">
                <h1 class="grand-titre">Votre générosité est sur le point de créer un impact!</h1><z></z>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-8 mx-sm-auto">
                <form id="donation-form">
                    <input value="anrickk" type="text" id="name" placeholder="Name" required>
                    <input value="anrickk@gmail.com" type="email" id="email" placeholder="Email" required>
                    <input value="10" type="number" id="amount" placeholder="Amount" required>
                    <button type="submit" id="continue-btn">Continue</button>
                </form>
                <div id="payment-element" style="display: none;"></div>
                <button id="submit-payment" style="display: none;">Pay Now</button>
                <div id="card-errors" role="alert" class="text-center mt-3"></div>
            </div>
        </div>
    </div>

    <script>
        const stripe = Stripe('pk_test_51Q2owfB3dTrJX9EwFg8HTocUFxsOjtBgXzsh2OUofv08XonDpoyM7K858o0x7lIKIlZbafVtSWe7He8KFw6gGNvU00Q8ovekhT');
        let elements;
        let paymentIntentId;

        document.getElementById('donation-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const amount = document.getElementById('amount').value;

            const response = await fetch('/create-payment-intent', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name, email, amount })
            });

            const { clientSecret } = await response.json();
            paymentIntentId = clientSecret.split('_secret')[0];

            const appearance = {
                theme: 'stripe',
            };

            elements = stripe.elements({ clientSecret, appearance });
            const paymentElement = elements.create('payment');
            paymentElement.mount('#payment-element');

            document.getElementById('payment-element').style.display = 'block';
            document.getElementById('submit-payment').style.display = 'block';
            document.getElementById('donation-form').style.display = 'none';
        });

        document.getElementById('submit-payment').addEventListener('click', async (e) => {
            e.preventDefault();
            const { error } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: '{{ route('donate.thank-you') }}',
                }
            });

            if (error) {
                console.error(error);
                // Handle error (e.g., display to user)
            }
        });
    </script>
</main>

<footer>
    <x-footer/>
</footer>

</body>
</html>
