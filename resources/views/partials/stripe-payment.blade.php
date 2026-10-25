{{--
    Stripe Payment Element and Checkout button for a sign up form.
    On submit it creates a card payment method and submits the form with its id as payment_method; the server charges it.
    $formId: id of the sign up form
    $amount: price in dollars shown in wallets like Apple Pay; window.cartPrice overrides it on pages with a cart
--}}
<div class="uk-margin uk-width-1-1@s">
    <div class="uk-h2 uk-margin">Payment</div>
    <div id="payment-element"></div>
    <div id="payment-error" class="uk-text-danger uk-margin-small-top" role="alert"></div>
    <input type="hidden" name="payment_method">
</div>

<div class="uk-margin uk-width-1-1@s">
    <button class="uk-button uk-button-primary" id="checkout-button" type="submit">Checkout</button>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('{{ $formId }}');
        const checkoutButton = document.getElementById('checkout-button');
        const paymentError = document.getElementById('payment-error');
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const elements = stripe.elements({
            mode: 'payment',
            amount: {{ $amount * 100 }},
            currency: 'usd',
            paymentMethodTypes: ['card'],
            paymentMethodCreation: 'manual',
            appearance: { theme: 'stripe', variables: { colorPrimary: '#ff4870' } },
        });

        // Link would add bank and Klarna options; the server only accepts cards (including Apple Pay and Google Pay)
        elements.create('payment', { wallets: { link: 'never' } }).mount('#payment-element');

        function showPaymentError(message) {
            paymentError.textContent = message;
            checkoutButton.disabled = false;
        }

        form.addEventListener('submit', async function (event) {
            event.preventDefault();
            checkoutButton.disabled = true;
            paymentError.textContent = '';

            if (window.cartPrice) {
                elements.update({ amount: window.cartPrice * 100 });
            }

            const { error: submitError } = await elements.submit();

            if (submitError) {
                return showPaymentError(submitError.message);
            }

            const { error, paymentMethod } = await stripe.createPaymentMethod({
                elements,
                params: { billing_details: { email: form.elements.email.value } },
            });

            if (error) {
                return showPaymentError(error.message);
            }

            form.elements.payment_method.value = paymentMethod.id;
            form.submit();
        });
    });
</script>
