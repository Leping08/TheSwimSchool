@extends('layouts.app-uikit')

@section('seo')
    <title>Parrish Swim Lessons | Lakewood Ranch Swimming Classes | The Swim School</title>
    <meta name="description" content="The Swim School near Lakewood Ranch & Parrish is proud to offer private and semi-private swim lessons, as well as group swimming classes! Visit our website for more information."/>
@endsection

@section('heading')
    Private Lessons
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            @if($banner && $banner->active)
                <div class="uk-alert-primary" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    {!! $banner->text !!}
                </div>
            @endif

            <div class="uk-grid-margin uk-grid">

                <div class="uk-grid-item-match uk-flex-middle uk-width-4-5@m">
                    <div class="uk-panel uk-width-1-1">
                        <div class="uk-margin">
                            <div class="uk-dropcap">
                                Whether you are a beginner swimmer, a child preparing to join a <a href="{{ route('swim-team.index') }}">swim team</a>, or a triathlete
                                looking to improve your technique, private swim lessons can be customized to your specific needs
                                to help you achieve your goals quickly. These lessons are conducted one on one with an
                                instructor and each lesson is 30 minutes.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="uk-width-expand@m">
                    <div class="uk-margin-top">
                        <img src="/img/thank-you/smile.jpg" class="el-image uk-border-rounded uk-box-shadow-large" alt="Palmetto Swim Instruction">
                    </div>
                </div>
            </div>

            <div class="uk-width-4-4@m uk-first-column uk-margin-large-top">
                <h2 class="uk-heading-bullet">Location</h2>
                <p>Private Lessons take place at the River Wilderness Golf & Country Club.</p>
                <div class="uk-child-width-1-1@m">
                    <div class="uk-card uk-card-default">
                        <iframe height="300" class="uk-width-1-1" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=River+Wilderness+Golf+%26+Country+Club&key=AIzaSyAdLooRUbxGjnlY2k8HDa_zkXYQB4U7s9w&zoom=12" allowfullscreen></iframe>
                    </div>
                </div>
            </div>

            @if(config('season.private.season'))
                <div class="uk-grid-margin uk-grid uk-margin-large-top" uk-grid="">
                    <div class="uk-width-4-4@m uk-first-column">
                        <h2 class="uk-heading-bullet">Registration</h2>
                        <p class="">Registration opens on the 25th of each month for the next month’s available lessons and is first come first serve. Pricing is $35.00 per private lesson. Select at least one lesson to checkout. We suggest a minimum of at least 4-12 consecutive lessons for optimal development based on ability level and goals.</p>
                    </div>
                </div>


                <script src="https://checkout.stripe.com/checkout.js" type="application/javascript"></script>
                <script type="application/javascript">
                    let form = null;
                    document.addEventListener('DOMContentLoaded', function () {
                        form = document.getElementById('sign_up');
                        console.log('fdsfds');
                    }, false);

                    function openStripeCheckout() {
                        StripeCheckout.open({
                            name: 'The Swim School',
                            description: 'Private Lessons with The Swim School',
                            amount: (window.cartLength * 35) * 100,
                            key: '{{config('services.stripe.key')}}',
                            image: '/img/logos/TSS_png.png',
                            locale: 'auto',
                            token: function (token) {
                                console.log(token.id);
                                let hiddenInput = document.createElement('input');
                                hiddenInput.setAttribute('type', 'hidden');
                                hiddenInput.setAttribute('name', 'stripe_token');
                                hiddenInput.setAttribute('value', token.id);
                                form.appendChild(hiddenInput);
                                console.log(form);
                                // Submit the form
                                form.submit();
                            }
                        })
                    }
                </script>


                <div class="uk-grid-margin uk-grid">
                    <form class="uk-grid" id="sign_up" action="" method="POST">
                        <private-calendar events="{{ json_encode($events) }}">
                            <div class="uk-grid">
                                {{ csrf_field() }}
                                <div class="uk-h2 uk-margin uk-width-1-1 uk-margin-remove-top">
                                    Swimmer Information
                                </div>
                                <div class="uk-margin uk-width-1-2@m uk-width-1-1@s">
                                    <label class="uk-form-label uk-heading-bullet" for="first_name">First Name</label>
                                    <div class="uk-form-controls">
                                        <input type="text" class="uk-input" id="first_name" name="first_name" placeholder="First Name" value="{{ old('first_name') }}" required>
                                    </div>
                                </div>
                                <div class="uk-margin uk-width-1-2@m uk-width-1-1@s">
                                    <label class="uk-form-label uk-heading-bullet" for="last_name">Last Name</label>
                                    <div class="uk-form-controls">
                                        <input type="text" class="uk-input" id="last_name" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}" required>
                                    </div>
                                </div>
                                <div class="uk-margin uk-width-1-2@m uk-width-1-1@s">
                                    <label class="uk-form-label uk-heading-bullet" for="birth_date">Birth Date</label>
                                    <div class="uk-form-controls">
                                        <input type="date" class="uk-input" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
                                    </div>
                                </div>
                                <div class="uk-margin uk-width-1-2@m uk-width-1-1@s">
                                    <label class="uk-form-label uk-heading-bullet" for="parent">Name of Parent/Guardian (if
                                        applicable)</label>
                                    <div class="uk-form-controls">
                                        <input type="text" class="uk-input" id="parent" name="parent" placeholder="Parent/Guardian" value="{{ old('parent') }}">
                                    </div>
                                </div>


                                <hr class="uk-width-1-1">
                                <div class="uk-h2 uk-margin uk-width-1-1">
                                    Address
                                </div>
                                <div class="uk-margin uk-width-1-1">
                                    <label class="uk-form-label uk-heading-bullet" for="street">Street</label>
                                    <div class="uk-form-controls">
                                        <input type="address" class="uk-input" id="street" name="street" placeholder="Street" value="{{ old('street') }}" required>
                                    </div>
                                </div>

                                <div class="uk-margin uk-width-1-1@s uk-width-1-3@m">
                                    <label class="uk-form-label uk-heading-bullet" for="city">City</label>
                                    <div class="uk-form-controls">
                                        <input type="city" class="uk-input" id="city" name="city" placeholder="City" value="{{ old('city') }}" required>
                                    </div>
                                </div>

                                <div class="uk-margin uk-width-1-1@s uk-width-1-3@m">
                                    <label class="uk-form-label uk-heading-bullet" for="state">State</label>
                                    <div class="uk-form-controls">
                                        <input type="state" class="uk-input" id="state" name="state" placeholder="State" value="{{ old('state') }}" required>
                                    </div>
                                </div>

                                <div class="uk-margin uk-width-1-1@s uk-width-1-3@m">
                                    <label class="uk-form-label uk-heading-bullet" for="zip">Zip Code</label>
                                    <div class="uk-form-controls">
                                        <input type="numbers" class="uk-input" id="zip" name="zip" placeholder="Zip Code" value="{{ old('zip') }}" required>
                                    </div>
                                </div>


                                <hr class="uk-width-1-1">
                                <div class="uk-h2 uk-margin uk-width-1-1">
                                    Contact Information
                                </div>
                                <div class="uk-margin uk-width-1-1@s uk-width-1-2@m">
                                    <label class="uk-form-label uk-heading-bullet" for="phone">Phone</label>
                                    <div class="uk-form-controls">
                                        <input type="tel" class="uk-input" id="phone" name="phone" placeholder="Phone" value="{{ old('phone') }}" required>
                                    </div>
                                </div>
                                <div class="uk-margin uk-width-1-1@s uk-width-1-2@m">
                                    <label class="uk-form-label uk-heading-bullet" for="email">Email</label>
                                    <div class="uk-form-controls">
                                        <input type="email" class="uk-input" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                                    </div>
                                </div>
                                <div class="uk-form-controls">
                                    <label><input class="uk-checkbox" type="checkbox" name="emailUpdates" checked>
                                        Send me Swim School updates!
                                    </label>
                                </div>


                                <hr class="uk-width-1-1">
                                <div class="uk-h2 uk-margin uk-width-1-1">
                                    Emergency Contact Information
                                </div>
                                <div class="uk-margin uk-width-1-1@s uk-width-1-3@m">
                                    <label class="uk-form-label uk-heading-bullet" for="emergency_name">Emergency Contact
                                        Name</label>
                                    <div class="uk-form-controls">
                                        <input type="text" class="uk-input" id="emergency_name" name="emergency_name" placeholder="Name" value="{{ old('emergency_name') }}" required>
                                    </div>
                                </div>
                                <div class="uk-margin uk-width-1-1@s uk-width-1-3@m">
                                    <label class="uk-form-label uk-heading-bullet" for="emergency_relationship">Emergency
                                        Contact Relationship</label>
                                    <div class="uk-form-controls">
                                        <input type="text" class="uk-input" id="emergency_relationship" name="emergency_relationship" placeholder="Relationship" value="{{ old('emergency_relationship') }}" required>
                                    </div>
                                </div>
                                <div class="uk-margin uk-width-1-1@s uk-width-1-3@m">
                                    <label class="uk-form-label uk-heading-bullet" for="emergency_phone">Emergency Phone
                                        Number</label>
                                    <div class="uk-form-controls">
                                        <input type="tel" class="uk-input" id="emergency_phone" name="emergency_phone" placeholder="Phone" value="{{ old('emergency_phone') }}" required>
                                    </div>
                                </div>


                                <div class="uk-width-1-1@s">
                                    <div class="uk-form-controls">
                                        <label><input class="uk-checkbox" type="checkbox" name="terms" required>
                                            I agree to the <a href="{{ route('groups.terms') }}" target="_blank">The Swim
                                                School Policies & Procedures</a>
                                        </label>
                                    </div>
                                </div>

                                <div class="uk-margin uk-width-1-1@s">
                                    <button class="uk-button uk-button-primary" onclick="event.preventDefault(); if(form.reportValidity()){openStripeCheckout();}">Checkout</button>
                                </div>

                            </div>

                        </private-calendar>
                    </form>
                </div>
                <div class="uk-width-1-1@m uk-first-column uk-margin-large-top">
                    Home and community pool private lessons within the Parrish, Ellenton, and Palmetto areas are also available. For more information and details on requesting private lessons at your home or community pool, check out our <a href="{{ route('home_privates.index') }}">Home Private Lessons page</a>.
                </div>
                <div class="uk-width-1-1@m uk-first-column uk-margin-top">
                    For children under 3 years of age, we require a parent or trusted adult also get in the water to assist with the lessons. While our goal is certainly to teach your child to swim, we are not ISR certified instructors and do not specialize in the infant survival technique. We recommend participants under 12 months of age enroll in our group class <a href="{{ route('groups.lessons.index') }}">Parent & Infant program</a> prior to private lessons.
                </div>
            @endif
        </div>
    </div>
@endsection

