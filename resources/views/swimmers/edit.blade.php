@extends('layouts.app-uikit')

@section('heading')
Edit {{$swimmer->name}}
@endsection

@section('content')
<div class="uk-section-default uk-section-overlap uk-section">
    <div class="uk-container">
        <div class="uk-card uk-card-default">
            <div class="uk-card-body">
                <form method="POST" action="" class="uk-form-stacked">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PATCH">
                    <h3 class="uk-heading-bullet">Swimmer Infomation</h3>
                    <div class="uk-margin">
                        <label for="name"  class="uk-form-label">Swimmer Name</label>
                        <input type="text" class="uk-input" id="name" name="name" placeholder="Name" value="{{ old('name') ?? $swimmer->name }}" required>
                    </div>
                    <div class="uk-margin">
                        <label for="age"  class="uk-form-label">Swimmer Age</label>
                        <input type="number" class="uk-input" id="age" name="age" placeholder="Age" value="{{ old('age') ?? $swimmer->age }}" required>
                    </div>
                    <div class="uk-margin">
                        <label for="parent"  class="uk-form-label">Name of Parent/Guardian (if applicable)</label>
                        <input type="text" class="uk-input" id="parent" name="parent" placeholder="Parent/Guardian" value="{{ old('parent') ?? $swimmer->parent }}">
                    </div>
                    <hr>


                    <h3 class="uk-heading-bullet">Address</h3>
                    <div class="uk-margin">
                        <label for="street" class="uk-form-label">Street</label>
                        <input type="address" class="uk-input" id="street" name="street" placeholder="Street" value="{{ old('street') ?? $swimmer->street }}" required>
                    </div>
                    
                    <div class="uk-margin">
                        <label for="city" class="uk-form-label">City</label>
                        <input type="city" class="uk-input" id="city" name="city" placeholder="City" value="{{ old('city') ?? $swimmer->city }}" required>
                    </div>

                    <div class="uk-margin">
                        <label for="state" class="uk-form-label">State</label>
                        <input type="state" class="uk-input" id="state" name="state" placeholder="State" value="{{ old('state') ?? $swimmer->state }}" required>
                    </div>

                    <div class="uk-margin">
                        <label for="zip" class="uk-form-label">Zip Code</label>
                        <input type="numbers" class="uk-input" id="zip" name="zip" placeholder="Zip Code" value="{{ old('zip') ?? $swimmer->zip }}" required>
                    </div>
                    <hr>
                    <h3 class="uk-heading-bullet">Contact Infomation</h3>
                    
                    <div class="uk-margin">
                        <label for="phone" class="uk-form-label">Phone</label>
                        <input type="tel" class="uk-input" id="phone" name="phone" placeholder="Phone" value="{{ old('phone') ?? $swimmer->phone }}" required>
                    </div>
                    <div class="uk-margin">
                        <label for="email" class="uk-form-label">Email</label>
                        <input type="email" class="uk-input" id="email" name="email" placeholder="Email" value="{{ old('email') ?? $swimmer->email }}" required>
                    </div>

                    <hr>
                    <h3 class="uk-heading-bullet">Emergency Contact Infomation</h3>
                    
                    <div class="uk-margin">
                        <label for="emergencyName" class="uk-form-label">Emergency Contact Name</label>
                        <input type="text" class="uk-input" id="emergencyName" name="emergencyName" placeholder="Name" value="{{ old('emergencyName') ?? $swimmer->emergencyName }}" required>
                    </div>
                    <div class="uk-margin">
                        <label for="emergencyRelationship" class="uk-form-label">Emergency Contact Relationship</label>
                        <input type="text" class="uk-input" id="emergencyRelationship" name="emergencyRelationship" placeholder="Relationship" value="{{ old('emergencyRelationship') ?? $swimmer->emergencyRelationship }}" required>
                    </div>
                    <div class="uk-margin">
                        <label for="emergencyPhone" class="uk-form-label">Emergency Phone Number</label>
                        <input type="tel" class="uk-input" id="emergencyPhone" name="emergencyPhone" placeholder="Phone" value="{{ old('emergencyPhone') ?? $swimmer->emergencyPhone }}" required>
                    </div>

                    <hr>


                    <h3 class="uk-heading-bullet">Notes</h3>
                    
                    <div class="uk-margin">
                        <textarea class="uk-textarea" rows="5" id="exampleTextarea" name="notes">{{ old('notes') ?? $swimmer->notes }}</textarea>
                    </div>

                    <hr>

                    
                    <div>
                        <button type="submit" class="uk-button uk-button-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


