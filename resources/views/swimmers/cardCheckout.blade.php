@extends('layouts.app-uikit')

@section('heading')
Card Details
@endsection

@section('content')
<div class="uk-section-default uk-section-overlap uk-section">
    <div class="uk-container">
            <form class="uk-form-stacked" action="/{{{$lesson->id}}}/card/checkout" method="POST" id="payment-form">
                {{ csrf_field() }}
                <input name="swimmerId" type="hidden" value="{{{old('swimmerId') ? old('swimmerId') : $newSwimmer->id}}}" required>

                <div class="uk-margin uk-width-1-1@s">
                    <label class="uk-form-label uk-heading-bullet" for="cardholderName">Name</label>
                    <div class="uk-form-controls">
                        <input type="text" class="uk-input" id="cardholderName" name="cardholderName" placeholder="First Last" value="{{{old('cardholderName') ? old('cardholderName') : $newSwimmer->name}}}" required>
                    </div>
                </div>

                <div class="uk-margin uk-width-1-1@s">
                    <label class="uk-form-label uk-heading-bullet" for="cardholderEmail">Email</label>
                    <div class="uk-form-controls">
                        <input type="email" class="uk-input" id="cardholderEmail" name="cardholderEmail" placeholder="expamle@gmail.com" value="{{{old('cardholderEmail') ? old('cardholderEmail') : $newSwimmer->email}}}" required>
                    </div>
                </div>

                <div class="uk-margin uk-width-1-1@s">
                    <label class="uk-form-label uk-heading-bullet" for="cardholderEmail">Card</label>
                    <div id="card-element" class="uk-input"></div>
                </div>

                <!-- Used to display form errors -->
                <div id="card-errors" role="alert"></div>
                <button class="uk-button uk-button-primary" type="submit">Pay ${{$lesson->price}}</button>
            </form>
        </div>
    </div>
</div>


<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener("DOMContentLoaded", function(){
    let stripe = Stripe(window.laravelConfig.STRIPE_PUBLIC);
    let elements = stripe.elements();

    let card = elements.create('card', {
        style: {
            base: {
            iconColor: '#666EE8',
            color: '#31325F',
            lineHeight: '40px',
            fontWeight: 300,
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSize: '15px',
                '::placeholder': {
                    color: '#CFD7E0'
                }
            }
        }
    });
    card.mount('#card-element');


    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        let form = document.getElementById('payment-form');
        let hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        // Submit the form
        form.submit();
    }

    function createToken() {
        stripe.createToken(card).then(function(result) {
            if (result.error) {
            // Inform the user if there was an error
            let errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
            } else {
            // Send the token to your server
            stripeTokenHandler(result.token);
            }
        });
    }

    //Create a token when the form is submitted.
    let form = document.getElementById('payment-form');
    let formSubmitted = false;
    form.addEventListener('submit', function(e) {
        if(!formSubmitted) {
            formSubmitted = true;
            e.preventDefault();
            createToken();
        }
    });

    card.addEventListener('change', function(event) {
        let displayError = document.getElementById('card-errors');
        if (event.error) {
            formSubmitted = false;
            displayError.textContent = event.error.message;

        } else {
            formSubmitted = false;
            displayError.textContent = '';
        }
    });
});
</script>
@endsection
