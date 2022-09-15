@extends('layouts.app-uikit')

@section('seo')
    <title>Parrish Swim Team Sign Up | Group Swimming near Sun City Center | Bradenton</title>
    <meta name="description" content="Thank you for signing up for our Parrish swim team! We are so excited to have you join us for group swimming near Sun City Center and Bradenton. See you at the pool!"/>
@endsection

@section('heading')
    {{ config('swim-team.full-name') }}
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-card uk-card-default">
                <div class="uk-card-body">
                    <div class="uk-h2 uk-margin uk-width-1-1 uk-margin-remove-top">
                        {{$season->dates}} Registration
                    </div>

                    <hr class="uk-width-1-1">

                    <div>
                      Hey <b>{{$athlete->firstName}} {{$athlete->lastName}}</b>, we're so excited to have you join us for the {{$season->dates}} season! We've got a few things we need to get squared away before you can start swimming with us.
                    </div>

					<div class="uk-margin">
						<h3 class="uk-margin-remove-bottom">1. Review the Practice Schedule</h3>
						<p class="uk-margin-remove-top">We believe you are ready to swim in the <b>{{$level->name}}</b> level for the {{$season->dates}} season. Please review the practice schedule.</p>
					</div>

					<div class="uk-child-width-expand@s uk-margin" uk-grid>
						<div><i class="fa fa-calendar fa-lg" aria-hidden="true"></i> <strong>Season:<br></strong> {{$season->dates}}</div>
						<div><i class="fa fa-clock-o fa-lg" aria-hidden="true"></i> <strong>Practice Schedule:<br></strong>
							@foreach($level->schedule as $day)
								{{$day->day}} {{\Carbon\Carbon::parse($day->pivot->start_time)->format('g:ia')}} - {{\Carbon\Carbon::parse($day->pivot->end_time)->format('g:ia')}}<br>
							@endforeach
						</div>
						<div><i class="fa fa-map-marker fa-lg" aria-hidden="true"></i> <strong>Location:</strong><br>{{ config('swim-team.address') }}</div>
						<div><i class="fa fa-money fa-lg" aria-hidden="true"></i> <strong>Monthly Price:</strong><br>${{ $level->price }}</div>
					</div>

                    <div class="uk-margin">
                      <h3 class="uk-margin-remove-bottom">2. Complete the Registration Form</h3>
                      <div>We need to make sure you're all set up in our system. Please complete the registration form below.</div>
                    </div>

                    <div class="uk-margin">
                      <h3 class="uk-margin-remove-bottom">3. Pay the Registration Fee</h3>
                      <div>Once you've completed the registration form, you'll be able to pay the registration fee. It is $100 and due at the time of registration.</div>
                    </div>

                    <div class="uk-margin">
                      <h3 class="uk-margin-remove-bottom">4. Show Up to Practice</h3>
                      <div>You're all set to start swimming with us! We can't wait to see you at practice! The first recurring monthly fee will be withdrawn on the 1st of the next month. Please contact us at <a href="mailto:{{ config('swim-team.email') }}">{{ config('swim-team.email') }}</a> if you have any questions.</div>
                    </div>

                    <form class="uk-grid-small" id="sign-up" uk-grid action="" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="level_id" id="level_id" value="{{{$level->id}}}" required>
                        <input type="hidden" name="athlete_hash" id="athlete_hash" value="{{{$athlete->hash ?? null}}}" required>
                        <div class="uk-h2 uk-margin uk-width-1-1 uk-margin-remove-top">
                            Swimmer Information
                        </div>
                        <div class="uk-margin uk-width-1-2@m uk-width-1-1@s">
                            <label class="uk-form-label uk-heading-bullet" for="firstName">First Name</label>
                            <div class="uk-form-controls">
                                <input type="text" class="uk-input" id="firstName" name="firstName" placeholder="First Name" value="{{ old('firstName', $athlete->firstName ?? '') }}" required>
                            </div>
                        </div>
                        <div class="uk-margin uk-width-1-2@m uk-width-1-1@s">
                            <label class="uk-form-label uk-heading-bullet" for="lastName">Last Name</label>
                            <div class="uk-form-controls">
                                <input type="text" class="uk-input" id="lastName" name="lastName" placeholder="Last Name" value="{{ old('lastName', $athlete->lastName ?? '') }}" required>
                            </div>
                        </div>
                        <div class="uk-margin uk-width-1-2@m uk-width-1-1@s">
                            <label class="uk-form-label uk-heading-bullet" for="birthDate">Birth Date</label>
                            <div class="uk-form-controls">
                                <input type="date" class="uk-input" id="birthDate" name="birthDate" value="{{ \Carbon\Carbon::parse(old('birthDate', $athlete->birthDate ?? now()))->format('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="uk-margin uk-width-1-2@m uk-width-1-1@s">
                            <label class="uk-form-label uk-heading-bullet" for="parent">Name of Parent/Guardian (if applicable)</label>
                            <div class="uk-form-controls">
                                <input type="text" class="uk-input" id="parent" name="parent" placeholder="Parent/Guardian" value="{{ old('parent', $athlete->parent ?? '') }}">
                            </div>
                        </div>

                        <hr class="uk-width-1-1">
                        <div class="uk-h2 uk-margin uk-width-1-1">
                            Address
                        </div>
                        <div class="uk-margin uk-width-1-1">
                            <label class="uk-form-label uk-heading-bullet" for="street">Street</label>
                            <div class="uk-form-controls">
                                <input type="text" class="uk-input" id="street" name="street" placeholder="Street" value="{{ old('street', $athlete->street ?? '') }}" required>
                            </div>
                        </div>

                        <div class="uk-margin uk-width-1-1@s uk-width-1-3@m">
                            <label class="uk-form-label uk-heading-bullet" for="city">City</label>
                            <div class="uk-form-controls">
                                <input type="text" class="uk-input" id="city" name="city" placeholder="City" value="{{ old('city', $athlete->city ?? '') }}" required>
                            </div>
                        </div>

                        <div class="uk-margin uk-width-1-1@s uk-width-1-3@m">
                            <label class="uk-form-label uk-heading-bullet" for="state">State</label>
                            <div class="uk-form-controls">
                                <input type="text" class="uk-input" id="state" name="state" placeholder="State" value="{{ old('state', $athlete->state ?? '') }}" required>
                            </div>
                        </div>

                        <div class="uk-margin uk-width-1-1@s uk-width-1-3@m">
                            <label class="uk-form-label uk-heading-bullet" for="zip">Zip Code</label>
                            <div class="uk-form-controls">
                                <input type="text" class="uk-input" id="zip" name="zip" placeholder="Zip Code" value="{{ old('zip', $athlete->zip ?? '') }}" required>
                            </div>
                        </div>


                        <hr class="uk-width-1-1">
                        <div class="uk-h2 uk-margin uk-width-1-1">
                            Contact Information
                        </div>
                        <div class="uk-margin uk-width-1-1@s uk-width-1-2@m">
                            <label class="uk-form-label uk-heading-bullet" for="phone">Phone</label>
                            <div class="uk-form-controls">
                                <input type="tel" class="uk-input" id="phone" name="phone" placeholder="Phone" value="{{ old('phone', $athlete->phone ?? '') }}" required>
                            </div>
                        </div>
                        <div class="uk-margin uk-width-1-1@s uk-width-1-2@m">
                            <label class="uk-form-label uk-heading-bullet" for="email">Email</label>
                            <div class="uk-form-controls">
                                <input type="email" class="uk-input" id="email" name="email" placeholder="Email" value="{{ old('email', $athlete->email ?? '') }}" required>
                            </div>
                        </div>


                        <hr class="uk-width-1-1">
                        <div class="uk-h2 uk-margin uk-width-1-1">
                            Emergency Contact Information
                        </div>
                        <div class="uk-margin uk-width-1-1@s uk-width-1-3@m">
                            <label class="uk-form-label uk-heading-bullet" for="emergencyName">Emergency Contact Name</label>
                            <div class="uk-form-controls">
                                <input type="text" class="uk-input" id="emergencyName" name="emergencyName" placeholder="Name" value="{{ old('emergencyName', $athlete->emergencyName ?? '') }}" required>
                            </div>
                        </div>
                        <div class="uk-margin uk-width-1-1@s uk-width-1-3@m">
                            <label class="uk-form-label uk-heading-bullet" for="emergencyRelationship">Emergency Contact Relationship</label>
                            <div class="uk-form-controls">
                                <input type="text" class="uk-input" id="emergencyRelationship" name="emergencyRelationship" placeholder="Relationship" value="{{ old('emergencyRelationship', $athlete->emergencyRelationship ?? '') }}" required>
                            </div>
                        </div>
                        <div class="uk-margin uk-width-1-1@s uk-width-1-3@m">
                            <label class="uk-form-label uk-heading-bullet" for="emergencyPhone">Emergency Phone Number</label>
                            <div class="uk-form-controls">
                                <input type="tel" class="uk-input" id="emergencyPhone" name="emergencyPhone" placeholder="Phone" value="{{ old('emergencyPhone', $athlete->emergencyPhone ?? '') }}" required>
                            </div>
                        </div>

                        <promo_code :price="100"></promo_code>

                        <div class="uk-width-1-1@s">
                            <div class="uk-form-controls">
                                <label><input class="uk-checkbox" type="checkbox" name="termsAndConditions" required>
                                    I agree to the <a title="Swim Lessons near Sun City Center" href="{{ route('swim-team.terms') }}" target="_blank">{{ config('swim-team.full-name') }} Policies & Procedures</a>
                                </label>
                            </div>
                        </div>

                        <div class="uk-margin uk-width-1-1@s">
                            <button class="uk-button uk-button-primary" id="checkout" onclick="event.preventDefault(); if(form.reportValidity()){saveAthleteData();}">Checkout</button>
                        </div>

                    </form>

                    <script src="https://js.stripe.com/v3/" type="application/javascript"></script>
                    <!-- Display a payment form -->
                    <form id="payment-form">
                        <!-- <input type="text" id="email" placeholder="Enter email address" /> -->
                        <div id="payment-element">
                            <!--Stripe.js injects the Payment Element-->
                        </div>
                        <button class="uk-button uk-button-primary" id="submit" type="submit">
                            <div class="spinner hidden" id="spinner"></div>
                            <span id="button-text">Pay now</span>
                        </button>
                        <div id="payment-message" class="hidden"></div>
                    </form>

                    <script type="application/javascript">
                        // This is your test publishable API key.
                        const stripe = Stripe(window.laravelConfig.STRIPE_PUBLIC);
                        let elements;

                        // Hide pay now button
                        const payNowButton = document.getElementById('submit').style.display = 'none';

                        async function saveAthleteData() {
                            let athleteData = {
                                "firstName": document.getElementById("firstName").value,
                                "lastName": document.getElementById("lastName").value,
                                "birthDate": document.getElementById("birthDate").value,
                                "email": document.getElementById("email").value,
                                "parent": document.getElementById("parent").value,
                                "phone": document.getElementById("phone").value,
                                "street": document.getElementById("street").value,
                                "city": document.getElementById("city").value,
                                "state": document.getElementById("state").value,
                                "zip": document.getElementById("zip").value,
                                "emergencyName": document.getElementById("emergencyName").value,
                                "emergencyRelationship": document.getElementById("emergencyRelationship").value,
                                "emergencyPhone": document.getElementById("emergencyPhone").value,
                            }

                            // make api call to save the athlete data
                            let hash = document.getElementById('athlete_hash').value;
                            const response = await fetch(`/api/athlete/${hash}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify(athleteData)
                            });

                            let promoCode = document.getElementById('promo_code').value;

                            // Check if the promo code has something in it
                            if (promoCode) {
                                // Check for free promo code
                                let promoResponse = await fetch('/api/promo-code', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                        },
                                        body: JSON.stringify({
                                            "code": document.getElementById("promo_code").value,
                                        })
                                    })
                                    .then((response) => {
                                        return response.json();
                                    });
                                
                                // Create the swimmer from the athlete data with a free promo code
                                if (promoResponse >= 100) {
                                    let saveSwimmerResponse = await fetch('/api/swim-team/athlete/promo-code', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                        },
                                        body: JSON.stringify({
                                            "promo_code": document.getElementById("promo_code").value,
                                            "athlete_hash": document.getElementById('athlete_hash').value,
                                        })
                                    })
                                    .then((response) => {
                                        return response.json();
                                    });

                                    // Redirect to the thank you page
                                    if (saveSwimmerResponse.redirect) {
                                        window.location.href = saveSwimmerResponse.redirect;
                                    }
                                }
                            }

                            // If the promo was not free then open the stripe checkout
                            openCheckoutComponent();
                        }

                        function openCheckoutComponent() {
                            // Show pay now button
                            const payNowButton = document.getElementById('submit').style.display = 'inline-block';
                            // Hide checkout button
                            const checkoutButton = document.getElementById('checkout').style.display = 'none';


                            var formElem = document.getElementById('sign-up');
                            const formData = new FormData(formElem);

                            let data = {
                                name: formData.get('firstName') + ' ' + formData.get('lastName'),
                                email: formData.get('email'),
                                athlete_hash: formData.get('athlete_hash'),
                                level_id: formData.get('level_id'),
                                promo_code: formData.get('promo_code'),
                            };

                            initialize(data);
                            checkStatus();

                            // wait for the js to load
                            setTimeout(() => {
                                document.querySelector("#payment-form").addEventListener("submit", handleSubmit);
                            }, 500);
                        }

                        // Fetches a payment intent and captures the client secret
                        async function initialize(data) {
                            // todo add try catch here
                            const { clientSecret } = await fetch("/api/stripe-token/payment-intent/athlete", {
                                method: "POST",
                                headers: { "Content-Type": "application/json" },
                                body: JSON.stringify({
                                    name: data.name,
                                    email: data.email,
                                    athlete_hash: data.athlete_hash,
                                    level_id: data.level_id,
                                    promo_code: data.promo_code
                                }),
                            }).then((r) => r.json());
                    
                            elements = stripe.elements({ clientSecret });
                    
                            const paymentElement = elements.create("payment");
                            paymentElement.mount("#payment-element");
                        }
                
                        async function handleSubmit(e) {
                            e.preventDefault();
                            setLoading(true);
                    
                            // todo write test for this tonight
                            const { error } = await stripe.confirmPayment({
                                elements,
                                confirmParams: {
                                    // Make sure to change this to your payment completion page
									// todo update this page to work with athlete
                                    return_url: "{{ route('home.index') }}" + `/swim-team/save-swimmer/athlete/${document.getElementById('athlete_hash').value}`,
                                    receipt_email: document.getElementById("email").value,
                                }
                            });
                    
                            // This point will only be reached if there is an immediate error when
                            // confirming the payment. Otherwise, your customer will be redirected to
                            // your `return_url`. For some payment methods like iDEAL, your customer will
                            // be redirected to an intermediate site first to authorize the payment, then
                            // redirected to the `return_url`.
                            if (error.type === "card_error" || error.type === "validation_error") {
                                showMessage(error.message);
                            } else {
                                showMessage("An unexpected error occurred.");
                            }
                    
                            setLoading(false);
                        }
                
                        // Fetches the payment intent status after payment submission
                        async function checkStatus() {
                            const clientSecret = new URLSearchParams(window.location.search).get(
                                "payment_intent_client_secret"
                            );
                    
                            if (!clientSecret) {
                                return;
                            }
                    
                            const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);
                    
                            switch (paymentIntent.status) {
                                case "succeeded":
                                    showMessage("Payment succeeded!");
                                break;
                                case "processing":
                                    showMessage("Your payment is processing.");
                                break;
                                case "requires_payment_method":
                                    showMessage("Your payment was not successful, please try again.");
                                break;
                                default:
                                    showMessage("Something went wrong.");
                                break;
                            }
                        }
                
                        // ------- UI helpers -------
                
                        function showMessage(messageText) {
                            const messageContainer = document.querySelector("#payment-message");
                    
                            messageContainer.classList.remove("hidden");
                            messageContainer.textContent = messageText;
                    
                            setTimeout(function () {
                                messageContainer.classList.add("hidden");
                                messageText.textContent = "";
                            }, 4000);
                        }
                
                        // Show a spinner on payment submission
                        function setLoading(isLoading) {
                            if (isLoading) {
                                // Disable the button and show a spinner
                                document.querySelector("#submit").disabled = true;
                                document.querySelector("#spinner").classList.remove("hidden");
                                document.querySelector("#button-text").classList.add("hidden");
                            } else {
                                document.querySelector("#submit").disabled = false;
                                document.querySelector("#spinner").classList.add("hidden");
                                document.querySelector("#button-text").classList.remove("hidden");
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection