@extends('layouts.app-uikit')

@section('heading')
    North River Swim Team
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-card uk-card-default">
                <div class="uk-card-body">
                    <div class="uk-h2 uk-margin uk-width-1-1 uk-margin-remove-top">
                        {{$level->name}} Level Details
                    </div>
                    <div class="uk-child-width-expand@s" uk-grid>
                        <div><i class="fa fa-money fa-lg" aria-hidden="true"></i> <strong>Price:</strong> ${{$level->price}}</div>
                        <div><i class="fa fa-calendar fa-lg" aria-hidden="true"></i> <strong>Season Length:<br></strong> May 1st - August 31st</div>
                        <div><i class="fa fa-clock-o fa-lg" aria-hidden="true"></i> <strong>Practice Schedule:<br></strong>
                            @foreach($level->schedule as $day)
                                {{$day->day}} {{\Carbon\Carbon::parse($day->pivot->start_time)->format('g:ia')}} - {{\Carbon\Carbon::parse($day->pivot->end_time)->format('g:ia')}}<br>
                            @endforeach
                        </div>
                        <div><i class="fa fa-map-marker fa-lg" aria-hidden="true"></i> <strong>Location:</strong><br>2250 Wilderness Blvd W,<br>Parrish, FL 34219</div>
                    </div>

                    <hr class="uk-width-1-1">
                    <form class="uk-grid-small" uk-grid action="" method="POST">
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




                        <hr class="uk-width-1-1">
                        <div class="uk-h2 uk-margin uk-width-1-1">
                            Promo Code
                        </div>
                        <div class="uk-margin uk-width-1-1@s">
                            <label class="uk-form-label uk-heading-bullet" for="promo_code">Code</label>
                            <div class="uk-form-controls">
                                <input type="text" class="uk-input" id="promo_code" name="promo_code" placeholder="" value="{{ old('promo_code') }}">
                            </div>
                        </div>

                        <div class="uk-width-1-1@s">
                            <div class="uk-form-controls">
                                <label><input class="uk-checkbox" type="checkbox" name="Terms and Conditions" required>
                                    I agree to the <a href="/swim-team/policies-and-procedures" target="_blank">North River Swim Team Policies & Procedures</a>
                                </label>
                            </div>
                        </div>

                        <div class="uk-margin uk-width-1-1@s">
                            <button type="submit" class="uk-button uk-button-primary">Payment Method</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection






