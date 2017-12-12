@extends('layouts.app-uikit')

@section('heading')
    Edit {{$location->name}}
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-card uk-card-default">
                <div class="uk-card-body">
                    <form method="POST" action="/locations/{{{$location->id}}}" class="uk-form-stacked">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <h3 class="uk-heading-bullet">Location</h3>
                        <div class="uk-margin">
                            <label for="name"  class="uk-form-label">Name</label>
                            <input type="text" class="uk-input" id="name" name="name" placeholder="Name" value="{{ old('name') ?? $location->name }}" required>
                        </div>
                        <div class="uk-margin">
                            <label for="street"  class="uk-form-label">Street</label>
                            <input type="text" class="uk-input" id="street" name="street" placeholder="12345 Street" value="{{ old('street') ?? $location->street }}" required>
                        </div>
                        <div class="uk-margin">
                            <label for="city"  class="uk-form-label">City</label>
                            <input type="text" class="uk-input" id="city" name="city" placeholder="Sarasota" value="{{ old('city') ?? $location->city }}" required>
                        </div>
                        <div class="uk-margin">
                            <label for="state"  class="uk-form-label">State</label>
                            <input type="text" class="uk-input" id="state" name="state" placeholder="FL" value="{{ old('state') ?? $location->state }}" required>
                        </div>
                        <div class="uk-margin">
                            <label for="zip"  class="uk-form-label">Zip</label>
                            <input type="number" class="uk-input" id="zip" name="zip" placeholder="34202" value="{{ old('zip') ?? $location->zip }}" required>
                        </div>
                        <div class="uk-margin">
                            <label for="phoneNumber"  class="uk-form-label">Phone Number</label>
                            <input type="text" class="uk-input" id="phoneNumber" name="phoneNumber" placeholder="999-999-9999" value="{{ old('phoneNumber') ?? $location->phoneNumber }}" required>
                        </div>

                        <hr>

                        <!-- TODO: Add a cancel button -->
                        <div>
                            <button type="submit" class="uk-button uk-button-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


