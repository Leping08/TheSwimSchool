@extends('layouts.app-uikit')

@section('heading')
Card Details
@endsection

@section('content')
<div class="uk-section-default uk-section-overlap uk-section">
    <div class="uk-container">
            <form class="uk-form-stacked" action="/{{{$lesson->id}}}/card/test" method="POST" id="payment-form">
            {{ csrf_field() }}
            <input name="swimmerId" type="hidden" value="{{{$newSwimmer->id}}}">
            <div class="group">
                <label class="uk-form-label">
                    <span>Name</span>
                    <input name="cardholderName" class="field" placeholder="First Last" value="{{{$newSwimmer->name}}}"/>
                </label>

                <label class="uk-form-label">
                    <span>Email</span>
                    <input name="cardholderEmail" class="field" placeholder="expamle@gmail.com" value="{{{$newSwimmer->email}}}"/>
                </label>
                <!--<label>
                <span>Phone</span>
                <input class="field" placeholder="(123) 456-7890" type="tel" />
                </label>-->
            </div>
            <div class="group">
                <label class="uk-form-label">
                <span>Card</span>
                <div id="card-element" class="field"></div>
                </label>
            </div>
            <!-- Used to display form errors -->
            <div id="card-errors" role="alert"></div>
                <button class="uk-button uk-button-primary" type="submit">Pay ${{$lesson->price}}</button>
            </form>
        </div>
    </div>
</div>

<style>
.group {
  background: white;
  box-shadow: 0 7px 14px 0 rgba(49,49,93,0.10),
              0 3px 6px 0 rgba(0,0,0,0.08);
  border-radius: 4px;
  margin-bottom: 20px;
}

label {
  position: relative;
  color: #8898AA;
  font-weight: 300;
  height: 40px;
  line-height: 40px;
  margin-left: 20px;
  display: block;
}

.group label:not(:last-child) {
  border-bottom: 1px solid #F0F5FA;
}

label > span {
  width: 20%;
  text-align: right;
  float: left;
}

.field {
  background: transparent;
  font-weight: 300;
  border: 0;
  color: #31325F;
  outline: none;
  padding-right: 10px;
  padding-left: 10px;
  cursor: text;
  width: 70%;
  height: 40px;
  float: right;
}

.field::-webkit-input-placeholder { color: #CFD7E0; }
.field::-moz-placeholder { color: #CFD7E0; }
.field:-ms-input-placeholder { color: #CFD7E0; }

.outcome {
  float: left;
  width: 100%;
  padding-top: 8px;
  min-height: 24px;
  text-align: center;
}

.success, .error {
  display: none;
  font-size: 13px;
}

.success.visible, .error.visible {
  display: inline;
}

.error {
  color: #E4584C;
}

.success {
  color: #666EE8;
}

.success .token {
  font-weight: 500;
  font-size: 13px;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function(){
    var stripe = Stripe('pk_test_IsSKy35BLDv1INihMjtgEhIi');
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
            color: '#CFD7E0',
        },
        },
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
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        createToken();
    });

    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
});
</script>
@endsection
