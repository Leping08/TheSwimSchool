@extends('layouts.app-uikit')

@section('heading')
    Checkout
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-card uk-card-default uk-card-body">
                <h2 class="uk-heading-line"><span>Card Details</span></h2>
                <form class="uk-form-stacked" action="/swim-team/card/checkout" method="POST" id="payment-form">
                    {{ csrf_field() }}

                    <input name="swimmerId" type="hidden" value="{{{old('swimmerId') ? old('swimmerId') : $swimmer->id}}}" required>

                    <div class="uk-margin uk-width-1-1@s">
                        <label class="uk-form-label uk-heading-bullet" for="cardholderName">Name</label>
                        <div class="uk-form-controls">
                            <input type="text" class="uk-input" id="cardholderName" name="cardholderName" placeholder="First Last" value="{{{old('cardholderName') ? old('cardholderName') : ''}}}" required>
                        </div>
                    </div>

                    <div class="uk-margin uk-width-1-1@s">
                        <label class="uk-form-label uk-heading-bullet" for="cardholderEmail">Email</label>
                        <div class="uk-form-controls">
                            <input type="email" class="uk-input" id="cardholderEmail" name="cardholderEmail" placeholder="expamle@gmail.com" value="{{{old('cardholderEmail') ? old('cardholderEmail') : $swimmer->email}}}" required>
                        </div>
                    </div>

                    <div class="uk-margin uk-width-1-1@s">
                        <label class="uk-form-label uk-heading-bullet" for="cardholderEmail">Card</label>
                        <div id="card-element" class="uk-input"></div>
                    </div>

                    <table class="uk-table uk-table-striped uk-table-divider">
                        <tbody>
                        <tr>
                            <td>Swim Team {{$swimmer->level->name}} Level</td>
                            <td>${{$swimmer->level->price}}</td>
                        </tr>
                        <tr>
                            <td>Promo Code</td>
                            @if($swimmer->promoCode)
                                <td>%{{$swimmer->promoCode->discount_percent}} Off</td>
                            @else
                                <td>None</td>
                            @endif
                        </tr>
                        <tr>
                            <td><b>Total</b></td>
                            <td><b>${{$swimmer->promoAppliedPrice()}}</b></td>
                        </tr>
                        </tbody>
                    </table>

                    <!-- Used to display form errors -->
                    <div id="card-errors" role="alert"></div>
                    <button class="uk-button uk-button-primary" type="submit">Pay ${{$swimmer->promoAppliedPrice()}}</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function(){
            var stripe = Stripe(window.laravelConfig.STRIPE_PUBLIC);
            var elements = stripe.elements();

            var card = elements.create('card', {
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
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
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
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        // Send the token to your server
                        stripeTokenHandler(result.token);
                    }
                });
            };

            // Create a token when the form is submitted.
            var form = document.getElementById('payment-form');
            var formSubmitted = false;
            form.addEventListener('submit', function(e) {
                if(!formSubmitted) {
                    formSubmitted = true;
                    e.preventDefault();
                    createToken();
                }
            });

            card.addEventListener('change', function(event) {
                var displayError = document.getElementById('card-errors');
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
