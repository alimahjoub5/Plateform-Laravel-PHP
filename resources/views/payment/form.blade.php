@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Paiement pour la facture #{{ $invoice->InvoiceID }}</h1>
    <p>Montant à payer : {{ $invoice->Amount }} €</p>

    <form action="{{ route('payment.process', $invoice->InvoiceID) }}" method="POST" id="payment-form">
        @csrf
        <div id="card-element">
            <!-- Stripe Card Element sera injecté ici -->
        </div>
        <button id="submit-button" class="btn btn-success mt-3">Payer</button>
    </form>
    
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ env("STRIPE_KEY") }}');
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');
    
        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async (event) => {
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
                form.appendChild(hiddenInput);
    
                // Ajouter l'ID de la facture au formulaire
                const invoiceIdInput = document.createElement('input');
                invoiceIdInput.setAttribute('type', 'hidden');
                invoiceIdInput.setAttribute('name', 'invoiceId');
                invoiceIdInput.setAttribute('value', '{{ $invoice->InvoiceID }}');
                form.appendChild(invoiceIdInput);
    
                form.submit();
            }
        });
    </script>
@endsection