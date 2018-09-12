@extends('layouts.app-uikit')

@section('heading')
    Checkout
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-card uk-card-default uk-card-body">
                <h2 class="uk-heading-line"><span>Card Details</span></h2>
                <form class="uk-form-stacked" action="/swim-team/checkout" method="POST" id="payment-form">
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
    @include('stripe.checkoutJS')
@endsection
