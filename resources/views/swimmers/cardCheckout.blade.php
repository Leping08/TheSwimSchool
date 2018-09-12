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
    @include('stripe.checkoutJS')
@endsection
