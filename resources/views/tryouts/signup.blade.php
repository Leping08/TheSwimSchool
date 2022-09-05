@extends('layouts.app-uikit')

@section('seo')
    <title>{{ config('swim-team.full-name') }} Tryout | The Swim School | Bradenton Parrish</title>
    <meta name="description" content="Thank you for your interest in our {{ config('swim-team.full-name') }} Tryout! The Swim School, serving Bradenton & Parrish, will be in contact with you soon!"/>
@endsection

@section('heading')
    Tryout Sign Up
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            @if(($tryout->class_size - $tryout->athletes->count()) <= 0)
                <div class="uk-card uk-card-default">
                    <div class="uk-card-body">
                        <div>Sorry this lesson is full. Sign up for a different tryout <a title="{{ config('swim-team.full-name') }}" href="{{ route('swim-team.tryouts.index') }}">here</a>.</div>
                    </div>
                </div>
            @else
                <div class="uk-card uk-card-default uk-card-body">
                    <div class="uk-h2 uk-margin uk-width-1-1 uk-margin-remove-top">
                        Tryout Information
                    </div>
                    <hr>
                    <div class="uk-child-width-expand@s" uk-grid>
                        <div><i class="fa fa-user fa-lg" aria-hidden="true"></i> <strong>Spots Remaining:</strong> {{$tryout->class_size - $tryout->athletes->count()}}</div>
                        <div><i class="fa fa-calendar fa-lg" aria-hidden="true"></i> <strong>Date:</strong> {{$tryout->event_time->format('F jS')}}</div>
                        <div><i class="fa fa-clock-o fa-lg" aria-hidden="true"></i> <strong>Time:</strong> {{$tryout->event_time->format('g:i a')}} - {{$tryout->event_time->addHour()->format('g:i a')}}</div>
                    </div>
                    <div class="uk-child-width-expand@s" uk-grid>
                        <iframe height="300" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q={{urlencode(config('swim-team.google-maps-query'))}}&key={{config('google.maps.api_key')}}&zoom=12" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="uk-card uk-card-default uk-margin-top">
                    <div class="uk-card-body">
                        <form class="uk-grid-small" uk-grid action="{{ route('swim-team.athlete.store', ['tryout' => $tryout]) }}" method="POST">
                            {{ csrf_field() }}
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


{{--                            <div class="uk-width-1-1@s">--}}
{{--                                <div class="uk-form-controls">--}}
{{--                                    <label><input class="uk-checkbox" type="checkbox" name="Terms and Conditions" required>--}}
{{--                                        I agree to the <a href="{{ route('swim-team.terms') }}" target="_blank">The Swim School Policies & Procedures</a>--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <div class="uk-margin uk-width-1-1@s">
                                <button type="submit" class="uk-button uk-button-primary">Sign Up</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
