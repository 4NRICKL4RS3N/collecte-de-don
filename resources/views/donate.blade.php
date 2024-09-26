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
        <div class="row">
            <div class="col-8"></div>
            <div class="col-4">
                <form id="donation-form" class="container mt-5 p-4 border-0 rounded">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" class="form-control form-input" required placeholder="Enter your name">
                    </div>
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control form-input" required placeholder="Enter your email">
                    </div>
                    <div class="form-group mb-3">
                        <label for="amount" class="form-label">Donation Amount</label>
                        <input type="number" id="amount" name="amount" class="form-control form-input" required
                               placeholder="Enter donation amount">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Card Details</label>
                        <div class="mb-3 input-container">
                            <ul class="list-group list-group-horizontal cb-list">
                                @foreach($cb_svg as $svg)
                                    @php
                                        $filename = basename($svg);
                                    @endphp
                                    <li class="list-group-item border-0 align-content-center">
                                        <img src="{{ asset('svg/cb/' . $filename) }}" alt="{{ $filename }}" class="img-fluid" style="width: 30px;">
                                    </li>
                                @endforeach
                            </ul>
                            <div id="card-number"></div>
                        </div>
                        <div class="mb-3">
                            <div id="card-expiry" class="form-control"></div>
                        </div>
                        <div class="mb-3">
                            <div id="card-cvc" class="form-control"></div>
                        </div>
                        <div class="mb-3">
                            <div id="card-zip" class="form-control"></div>
                        </div>
                        <div id="card-errors" class="text-danger mt-2" role="alert"></div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Donate</button>
                </form>
                <div id="result-message" class="text-center mt-3"></div>
            </div>
        </div>
    </div>

    <script>
        var stripe = Stripe('pk_test_51Q2owfB3dTrJX9EwFg8HTocUFxsOjtBgXzsh2OUofv08XonDpoyM7K858o0x7lIKIlZbafVtSWe7He8KFw6gGNvU00Q8ovekhT');
        var elements = stripe.elements();

        var cardNumber = elements.create('cardNumber', {
            classes: {
                base: 'form-control form-input',
            }
        });
        const cardNumberElement = document.getElementById('card-number');
        const inputContainer = document.querySelector('.input-container');
        cardNumber.on('focus', function() {
            inputContainer.classList.add('focused');
        });
        cardNumber.mount('#card-number');

        var cardExpiry = elements.create('cardExpiry');
        cardExpiry.mount('#card-expiry');

        var cardCvc = elements.create('cardCvc');
        cardCvc.mount('#card-cvc');

        var cardZip = elements.create('postalCode');
        cardZip.mount('#card-zip');

        var form = document.getElementById('donation-form');
        var resultMessage = document.getElementById('result-message');

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            stripe.createToken(cardNumber).then(function (result) {
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
