@extends('client.layouts.app')

@section('titre', 'Faire un don')

@push('scripts_head')
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row my-5">
            <div class="col-lg-7 col-md-6 ">
                <h1 class="grand-titre">Votre générosité est sur le point de créer un impact !</h1>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-8 mx-sm-auto">
                <div class="container p-4 border-0 rounded-4 donation_container">
                    <form id="donation-form">
                        <div class="form-group mb-3">
                            <label for="name" class="mb-0 form-label">Nom</label>
                            <input name="name" class="form-control form-input" type="text" id="name" placeholder="Name"
                                   required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="mb-0 form-label">Email</label>
                            <input name="email" class="form-control form-input" type="email" id="email"
                                   placeholder="Email"
                                   required>
                        </div>
                        <label for="amount" class="mb-0 form-label">Montant</label>
                        <div id="select-amount" class="mb-1">
                            <button type="button" class="mb-1 me-1 btn btn-outline-primary amount-btn" data-amount="5">
                                $5
                            </button>
                            <button type="button" class="mb-1 me-1 btn btn-outline-primary amount-btn" data-amount="10">
                                $10
                            </button>
                            <button type="button" class="mb-1 me-1 btn btn-outline-primary amount-btn" data-amount="20">
                                $20
                            </button>
                            <button type="button" class="mb-1 me-1 btn btn-outline-primary amount-btn" data-amount="50">
                                $50
                            </button>
                        </div>
                        <div class="mb-3">
                            <input class="form-control form-input" name="custom-amount" type="number" id="custom-amount"
                                   placeholder="Montant" required>
                        </div>
                        <input type="hidden" name="amount" id="amount">
                        <button class="btn btn-primary my-2 my-lg-0" type="submit" id="continue-btn">
                            <span class="btn-content">
                                <span class="btn-text">Continuer</span>
                                <span class="loader" id="loading-sprite-element"></span>
                            </span>
                        </button>
                    </form>
                    <div id="payment-element" style="display: none;"></div>
                    <div class="row">
                        <div class="col w-auto">
                            <button class="btn btn-primary mt-3" id="submit-payment" style="display: none;">
                                <span class="btn-content">
                                    <span class="btn-text">Confirmer</span>
                                    <span class="loader" id="loading-payment"></span>
                                </span>
                            </button>
                        </div>
                        <div class="col w-auto">
                            <button class="btn btn-outline-primary mt-3" id="go-back" style="display: none;">
                                Retour
                            </button>
                        </div>
                    </div>
                </div>
                <div id="card-errors" role="alert" class="text-center mt-3"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var notyf = new Notyf({
            position: {x: 'center', y: 'top'},
        });
        {{--    stripe    --}}
        const stripe = Stripe('pk_test_51Q2owfB3dTrJX9EwFg8HTocUFxsOjtBgXzsh2OUofv08XonDpoyM7K858o0x7lIKIlZbafVtSWe7He8KFw6gGNvU00Q8ovekhT');
        let elements;
        let paymentIntentId;
        const name_input = document.getElementById('name');
        const email_input = document.getElementById('email');
        const amount_input = document.getElementById('amount');
        const continue_button = document.getElementById('continue-btn');
        const continue_button_text = continue_button.querySelector('.btn-text');
        const submit_button = document.getElementById('submit-payment');
        const go_back_button = document.getElementById('go-back');
        const payment_element_container = document.getElementById('payment-element');
        const amountButtons = document.querySelectorAll(".amount-btn");
        const customAmountInput = document.getElementById("custom-amount");
        const loadingContinue = document.getElementById('loading-sprite-element');
        const loadingSubmit = document.getElementById('loading-payment');
        let paymentElement;

        const donation_form = document.getElementById('donation-form');
        let urlParams = new URLSearchParams(window.location.search);

        let donation = null;
        async function handleFormSubmit(e) {
            e.preventDefault();
            const name = name_input.value;
            const email = email_input.value;
            const amount = amount_input.value;
            const project = urlParams.get('project');

            continue_button_text.style.display = 'none';
            loadingContinue.style.display = 'inline-block';
            try {
                const response = await fetch('{{route('createPaymentIntent')}}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({name, email, amount, project})
                });

                const { clientSecret, donation_id } = await response.json();
                donation = donation_id;
                paymentIntentId = clientSecret.split('_secret')[0];

                const appearance = {
                    theme: 'flat',
                    variables: {
                        colorPrimary: '#DF253A',
                        colorBackground: '#ffffff',
                        colorText: '#30313d',
                        colorDanger: '#B22222',
                        fontFamily: 'Roc Grotesk',
                        spacingUnit: '2px',
                        borderRadius: '4px',
                    },
                    rules: {
                        '.Label': {
                            color: 'white',
                        },
                        '.Input': {
                            transition: 'all 0.1s ease',
                            outline: '0 solid white',
                        },
                        '.Input:focus': {
                            boxShadow: 'none',
                            transition: 'all 0.1s ease',
                            outline: '2px solid #DF253A',
                        },
                        '.Tab:active': {
                            boxShadow: 'none',
                        }
                    }
                };
                const style = {
                    label: {
                        color: 'white',
                    },
                }
                elements = stripe.elements({clientSecret, appearance});
                paymentElement = elements.create('payment', style);
                paymentElement.mount('#payment-element');
            } catch (e) {
                //annuler le don
                fetch(`/donate/failed/${donation}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            notyf.error('Don annulé');
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });

            } finally {
                payment_element_container.style.display = 'block';
                submit_button.style.display = 'block';
                go_back_button.style.display = 'block';
                name_input.disabled = true;
                email_input.disabled = true;
                amount_input.disabled = true;
                customAmountInput.disabled = true;
                continue_button.hidden = true;
                loadingContinue.style.display = 'none';
            }
        }

        async function handlePaymentSubmit(e) {
            e.preventDefault();
            submit_button.querySelector('.btn-text').style.display = 'none';
            loadingSubmit.style.display = 'inline-block';

            const {error} = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: '{{ route('donate.thank-you') }}',
                }
            });

            if (error) {
                console.error(error);
                // Handle error (e.g., display to user)
            }
        }

        function handleGoBack() {
            fetch(`/donate/delete/${donation}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('donation deleted')
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

            if (paymentElement) {
                paymentElement.unmount();
                paymentElement = null;
            }
            payment_element_container.style.display = 'none';
            submit_button.style.display = 'none';
            go_back_button.style.display = 'none';
            name_input.disabled = false;
            email_input.disabled = false;
            amount_input.disabled = false;
            customAmountInput.disabled = false;
            continue_button.hidden = false;
            continue_button_text.style.display = 'inline-block';
        }

        donation_form.addEventListener('submit', handleFormSubmit);
        submit_button.addEventListener('click', handlePaymentSubmit);
        go_back_button.addEventListener('click', handleGoBack);

        document.addEventListener("DOMContentLoaded", function () {
            function clearActiveButtons() {
                amountButtons.forEach(button => button.classList.remove("active"));
            }

            amountButtons.forEach(button => {
                button.addEventListener("click", function () {
                    clearActiveButtons();
                    this.classList.add("active");
                    amount_input.value = this.getAttribute("data-amount");
                    customAmountInput.value = "";
                    customAmountInput.required = false;
                });
            });

            customAmountInput.addEventListener("input", function () {
                if (this.value !== "") {
                    clearActiveButtons();
                    hiddenAmountInput.value = this.value;
                }
            });
        });
    </script>
@endpush
