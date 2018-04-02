@extends('layouts.app-uikit')

@section('heading')
    Edit Tryout {{$tryout->id}}
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-card uk-card-default">
                <div class="uk-card-body">
                    <form method="POST" action="/tryouts/{{{$tryout->id}}}" class="uk-form-stacked">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PATCH">

                        <div class="uk-margin">
                            <label for="registration_open" class="uk-form-label uk-heading-bullet">Registration Open</label>
                            <input type="date" class="uk-input" id="registration_open" name="registration_open" value="{{ old('registration_open') ?? $tryout->registration_open->format('Y-m-d') }}" required>
                        </div>

                        <div class="uk-margin">
                            <label for="event_time" class="uk-form-label uk-heading-bullet">Tryout Time</label>
                            <input type="datetime-local" class="uk-input" id="event_time" name="event_time" value="{{ old('event_time') ?? $tryout->event_time->format('Y-m-d\Th:m:s') }}" required>
                        </div>

                        <div class="uk-margin uk-width-1-1@s">
                            <label class="uk-form-label uk-heading-bullet" for="class_size">Class Size</label>
                            <div class="uk-form-controls">
                                <input type="number" class="uk-input" id="class_size" name="class_size" placeholder="10" value="{{ old('class_size') ?? $tryout->class_size }}" required>
                            </div>
                        </div>

                        <div class="uk-margin uk-width-1-1@s">
                            <label class="uk-form-label uk-heading-bullet" for="location_id">Location</label>
                            <div class="uk-form-controls">
                                <select class="uk-select" name="location_id" id="location_id">
                                    @foreach($locations as $location)
                                        <option value="{{  old('location_id') ?? $location->id}}" {{$location->id === $tryout->location->id ? 'selected' : '' }}>{{$location->name}}</option>
                                    @endforeach
                                </select>
                            </div>
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


