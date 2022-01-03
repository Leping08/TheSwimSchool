@extends('layouts.app-uikit')

@section('seo')
<title>Parrish Swimming Lessons | Ellenton Group Swim Lessons | Bradenton</title>
<meta name="description" content="Interested in Parrish swimming lessons? Sign up for group lessons in Parrish, Ellenton, and Bradenton today be selecting your child's age and level!"/>
@endsection

@section('heading')
Sign Up
@endsection

@section('content')
<div class="uk-section-default uk-section-overlap uk-section">
    <div class="uk-container">
    @if($lesson->class_size - $lesson->swimmers->count() <= 0)
        <div class="uk-card uk-card-default">
            <div class="uk-card-body">
                <div>This class is full. We recommend signing up for a different class with openings. If you choose to join the waitlist, we will notify you if any spots become available within 24-48 hours of the session start date.</div>
{{--                <div>Sorry this lesson is full. Sign up for a different lesson <a title="Bradenton Swimming Lessons"href="{{ route('groups.lessons.index') }}">here</a>.</div>--}}
            </div>
        </div>
    @else
        <div class="uk-child-width-expand uk-grid-collapse uk-grid-match uk-flex-middle uk-grid" uk-grid>
            <div class="uk-width-1-4@m">
                <div class="uk-card-media-left">
                    <div class="uk-flex uk-flex-center uk-text-center">
                        <div>
                            <img class="uk-width-3-4" src="{{asset($lesson->group->iconPath)}}" alt="Swim Lessons Ellenton">
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="uk-card-body">
                    <h2 class="uk-margin uk-h2 uk-margin-remove-adjacent">{{$lesson->group->type}}</h2>
                    <div class="uk-margin uk-text-meta uk-text-primary">{{$lesson->group->ages}}</div>
                    <div class="uk-margin">{{$lesson->group->description}}</div>
                </div>
            </div>
        </div>
        <div class="uk-card uk-card-default">
            <div class="uk-card-body">
                <div class="uk-flex uk-flex-between">
                    <div class="uk-h2 uk-margin-remove-top uk-margin-remove-bottom">
                        Lesson Details
                    </div>
                </div>
                <hr class="uk-width-1-1">
                <div class="uk-child-width-expand@s" uk-grid>
                    <div><i class="fa fa-users fa-lg" aria-hidden="true"></i> <strong>Class Size:</strong> {{$lesson->class_size}}</div>
                    <div><i class="fa fa-user fa-lg" aria-hidden="true"></i> <strong>Spots Remaining:</strong> {{$lesson->class_size - $lesson->swimmers->count()}}</div>
                </div>
                
                <div class="uk-child-width-expand@s" uk-grid>
                    <div><i class="fa fa-graduation-cap fa-lg" aria-hidden="true"></i> <strong>Instructor:</strong> <a href="{{ route('pages.about') . '#'. $lesson->instructor->name }}">{{$lesson->instructor->name}}</a></div>
                    <div><i class="fa fa-calendar fa-lg" aria-hidden="true"></i> <strong>Dates:</strong> {{$lesson->class_start_date->toFormattedDateString()}} - {{$lesson->class_end_date->toFormattedDateString()}}</div>
                </div>
                
                <div class="uk-child-width-expand@s" uk-grid>
                    <div><i class="fa fa-map-marker fa-lg" aria-hidden="true"></i> <strong>Location:</strong> {{$lesson->location->name}}<br><a target="_blank" href="https://www.google.com/maps/search/?api=1&query={{{$lesson->location->street}}}+{{{$lesson->location->city}}}+{{{$lesson->location->state}}}+{{{$lesson->location->zip}}}">{{$lesson->location->street}}, <br>{{$lesson->location->city}}, {{$lesson->location->state}} {{$lesson->location->zip}}</a></div>
                    <div><i class="fa fa-clock-o fa-lg" aria-hidden="true"></i> <strong>Times:</strong><br>
                        @foreach($lesson->DaysOfTheWeek as $day)
                        {{$day->day}} {{$lesson->class_start_time->format('g:i a')}} - {{$lesson->class_end_time->format('g:i a')}}<br>
                        @endforeach
                    </div>
                </div>
                
                <div class="uk-child-width-expand@s" uk-grid>
                    <div><i class="fa fa-money fa-lg" aria-hidden="true"></i> <strong>Price:</strong> ${{$lesson->price}}</div>
                </div>
                <hr class="uk-width-1-1">

                <script src="https://checkout.stripe.com/checkout.js"></script>
                <script>
                    let form = null;
                    document.addEventListener('DOMContentLoaded', function() {
                        form = document.getElementById('sign-up');
                        console.log(form);
                    }, false);

                     function openStripeCheckout() {
                        StripeCheckout.open({
                            name: 'The Swim School',
                            description: '{{$lesson->group->type}}',
                            amount: {{$lesson->price * 100}},
                            key: '{{config('services.stripe.key')}}',
                            image: '{{ asset('/img/logos/TSS_png.png') }}',
                            locale: 'auto',
                            token: function (token) {
                                console.log(token.id);
                                let hiddenInput = document.createElement('input');
                                hiddenInput.setAttribute('type', 'hidden');
                                hiddenInput.setAttribute('name', 'stripeToken');
                                hiddenInput.setAttribute('value', token.id);
                                form.appendChild(hiddenInput);
                                console.log(form);
                                // Submit the form
                                form.submit();
                            }
                        })
                    }
                </script>

                <form class="uk-grid-small" id="sign-up" uk-grid action="{{ route('groups.swimmers.store', [$lesson, $lesson->group]) }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="lesson_id" value="{{{$lesson->id}}}" required>
                    <div class="uk-h2 uk-margin uk-width-1-1 uk-margin-remove-top">
                        Swimmer Information
                    </div>
                    <div class="uk-margin uk-width-1-2@m uk-width-1-1@s">
                        <label class="uk-form-label uk-heading-bullet" for="firstName">First Name</label>
                        <div class="uk-form-controls">
                            <input type="text" class="uk-input" id="firstName" name="firstName" placeholder="First Name" value="{{ old('firstName') }}" required>
                        </div>
                    </div>
                    <div class="uk-margin uk-width-1-2@m uk-width-1-1@s">
                        <label class="uk-form-label uk-heading-bullet" for="lastName">Last Name</label>
                        <div class="uk-form-controls">
                            <input type="text" class="uk-input" id="lastName" name="lastName" placeholder="Last Name" value="{{ old('lastName') }}" required>
                        </div>
                    </div>
                    <div class="uk-margin uk-width-1-2@m uk-width-1-1@s">
                        <label class="uk-form-label uk-heading-bullet" for="birthDate">Birth Date</label>
                        <div class="uk-form-controls">
                            <input type="date" class="uk-input" id="birthDate" name="birthDate" value="{{ old('birthDate') }}" required>
                        </div>
                    </div>
                    <div class="uk-margin uk-width-1-2@m uk-width-1-1@s">
                        <label class="uk-form-label uk-heading-bullet" for="parent">Name of Parent/Guardian (if applicable)</label>
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
                        <label class="uk-form-label uk-heading-bullet" for="emergencyName">Emergency Contact Name</label>
                        <div class="uk-form-controls">
                            <input type="text" class="uk-input" id="emergencyName" name="emergencyName" placeholder="Name" value="{{ old('emergencyName') }}" required>
                        </div>
                    </div>
                    <div class="uk-margin uk-width-1-1@s uk-width-1-3@m">
                        <label class="uk-form-label uk-heading-bullet" for="emergencyRelationship">Emergency Contact Relationship</label>
                        <div class="uk-form-controls">
                            <input type="text" class="uk-input" id="emergencyRelationship" name="emergencyRelationship" placeholder="Relationship" value="{{ old('emergencyRelationship') }}" required>
                        </div>
                    </div>
                    <div class="uk-margin uk-width-1-1@s uk-width-1-3@m">
                        <label class="uk-form-label uk-heading-bullet" for="emergencyPhone">Emergency Phone Number</label>
                        <div class="uk-form-controls">
                            <input type="tel" class="uk-input" id="emergencyPhone" name="emergencyPhone" placeholder="Phone" value="{{ old('emergencyPhone') }}" required>
                        </div>
                    </div>

                    <hr class="uk-width-1-1">
                    <div class="uk-h2 uk-margin uk-width-1-1">
                        Price ${{$lesson->price}}
                    </div>

                    <div class="uk-width-1-1@s">
                        <div class="uk-form-controls">
                            <label><input class="uk-checkbox" type="checkbox" name="Terms and Conditions" required>
                                I agree to the <a title="Swimming Lessons Parrish" href="{{ route('groups.terms') }}" target="_blank">The Swim School Policies & Procedures</a>
                            </label>
                        </div>
                    </div>

                    <div class="uk-margin uk-width-1-1@s">
                        <button class="uk-button uk-button-primary" onclick="event.preventDefault(); if(form.reportValidity()){openStripeCheckout();}">Checkout</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection






