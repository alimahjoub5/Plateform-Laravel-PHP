@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Paiement pour la facture #{{ $invoice->InvoiceID ?? 'No Invoice' }}</h1>
    <p>Montant à payer : {{ $invoice->Amount ?? '0.00' }} €</p>

    <!-- Sélection du mode de paiement -->
    <div class="mb-4">
        <label for="payment-method">Choisissez un mode de paiement :</label>
        <select id="payment-method" class="form-control">
            <option value="stripe">Carte Bancaire (Stripe)</option>
            <option value="paypal">PayPal</option>
        </select>
    </div>

    <!-- Formulaire de paiement Stripe -->
    <div id="stripe-payment" class="payment-method">
        <form action="{{ route('payment.process', $invoice->InvoiceID ?? 0) }}" method="POST" id="stripe-form">
            @csrf
            <div id="card-element">
                <!-- Stripe Card Element sera injecté ici -->
            </div>
            <button id="stripe-submit-button" class="btn btn-success mt-3">Payer avec Stripe</button>
        </form>
    </div>

    <!-- Bouton de paiement PayPal -->
    <div id="paypal-payment" class="payment-method" style="display: none;">
        <div id="paypal-button-container"></div>
    </div>
</div>

<!-- Script Stripe -->
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env("STRIPE_KEY") }}');
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');

    const stripeForm = document.getElementById('stripe-form');
    stripeForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        const { paymentMethod, error } = await stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
        });

        if (error) {
            alert(error.message);
        } else {
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'payment_method');
            hiddenInput.setAttribute('value', paymentMethod.id);
            stripeForm.appendChild(hiddenInput);

            // Ajouter l'ID de la facture au formulaire
            const invoiceIdInput = document.createElement('input');
            invoiceIdInput.setAttribute('type', 'hidden');
            invoiceIdInput.setAttribute('name', 'invoiceId');
            invoiceIdInput.setAttribute('value', '{{ $invoice->InvoiceID ?? 0 }}');
            stripeForm.appendChild(invoiceIdInput);

            stripeForm.submit();
        }
    });
</script>

<!-- Script PayPal -->
<script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_SANDBOX_CLIENT_ID') }}&currency=EUR"></script>
<script>
    const paymentMethodSelect = document.getElementById('payment-method');
    const stripePaymentDiv = document.getElementById('stripe-payment');
    const paypalPaymentDiv = document.getElementById('paypal-payment');

    // Afficher/masquer les méthodes de paiement en fonction de la sélection
    paymentMethodSelect.addEventListener('change', function () {
        if (this.value === 'stripe') {
            stripePaymentDiv.style.display = 'block';
            paypalPaymentDiv.style.display = 'none';
        } else if (this.value === 'paypal') {
            stripePaymentDiv.style.display = 'none';
            paypalPaymentDiv.style.display = 'block';
        }
    });

    // Rendre le bouton PayPal
    paypal.Buttons({
        createOrder: function (data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '{{ $invoice->Amount ?? 0 }}',
                        currency_code: 'EUR'
                    },
                    description: 'Paiement pour la facture #{{ $invoice->InvoiceID ?? 0 }}'
                }]
            });
        },
        onApprove: function (data, actions) {
            return actions.order.capture().then(function (details) {
                // Créer un formulaire pour soumettre les données au serveur
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("paypal.process", $invoice->InvoiceID ?? 0) }}';

                // Ajouter le token CSRF
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Ajouter l'ID de la commande
                const orderID = document.createElement('input');
                orderID.type = 'hidden';
                orderID.name = 'orderID';
                orderID.value = data.orderID;
                form.appendChild(orderID);

                // Ajouter l'ID de la facture
                const invoiceID = document.createElement('input');
                invoiceID.type = 'hidden';
                invoiceID.name = 'invoiceID';
                invoiceID.value = '{{ $invoice->InvoiceID ?? 0 }}';
                form.appendChild(invoiceID);

                // Soumettre le formulaire
                document.body.appendChild(form);
                form.submit();
            });
        },
        onError: function (err) {
            console.error(err);
            alert('Une erreur s\'est produite lors du paiement. Veuillez réessayer.');
        }
    }).render('#paypal-button-container');
</script>

<style>
    .payment-method {
        margin-top: 20px;
    }
</style>
@endsection