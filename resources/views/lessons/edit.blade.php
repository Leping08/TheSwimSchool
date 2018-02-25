@extends('layouts.app-uikit')

@section('heading')
    Edit {{$lesson->group->type}}
@endsection

@section('content')

    <!-- TODO: Add form to edit lesson -->
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-card uk-card-default uk-width-1-1@s">
                <div class="uk-card-body">
                    <form class="uk-grid-small" uk-grid action="/lesson/{{$lesson->id}}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <div class="uk-margin uk-width-1-1@s">
                            <label class="uk-form-label uk-heading-bullet" for="group_id">Level</label>
                            <div class="uk-form-controls">
                                <select class="uk-select" name="group_id" id="group_id">
                                    @foreach($groups as $group)
                                        <option value="{{$group->id}}" {{$group->id === $lesson->group->id ? 'selected' : '' }}>{{$group->type}} ({{$group->ages}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="uk-margin uk-width-1-1@s">
                            <label class="uk-form-label uk-heading-bullet" for="location_id">Location</label>
                            <div class="uk-form-controls">
                                <select class="uk-select" name="location_id" id="location_id">
                                    @foreach($locations as $location)
                                        <option value="{{  old('location_id') ?? $location->id}}" {{$location->id === $lesson->location->id ? 'selected' : '' }}>{{$location->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="uk-margin uk-width-1-1@s">
                            <label class="uk-form-label uk-heading-bullet" for="price">Price</label>
                            <div class="uk-form-controls">
                                <input type="number" class="uk-input" id="price" name="price" placeholder="$60" value="{{ old('price') ?? $lesson->price }}" required>
                            </div>
                        </div>

                        <div class="uk-margin uk-width-1-1@s">
                            <label class="uk-form-label uk-heading-bullet" for="class_size">Class Size</label>
                            <div class="uk-form-controls">
                                <input type="number" class="uk-input" id="class_size" name="class_size" placeholder="10" value="{{ old('class_size') ?? $lesson->class_size }}" required>
                            </div>
                        </div>

                        <div class="uk-margin uk-width-1-1@s">
                            <label class="uk-form-label uk-heading-bullet" for="registration_open">Registration Opens</label>
                            <div class="uk-form-controls">
                                <input type="date" class="uk-input" id="registration_open" name="registration_open" value="{{ old('registration_open') ?? $lesson->registration_open->format('Y-m-d') }}" required>
                            </div>
                        </div>

                        <div class="uk-margin uk-width-1-1@s">
                            <label class="uk-form-label uk-heading-bullet" for="class_start_date">Start Date</label>
                            <div class="uk-form-controls">
                                <input type="date" class="uk-input" id="class_start_date" name="class_start_date" value="{{ old('class_start_date') ?? $lesson->class_start_date->format('Y-m-d') }}" required>
                            </div>
                        </div>

                        <div class="uk-margin uk-width-1-1@s">
                            <label class="uk-form-label uk-heading-bullet" for="class_end_date">End Date</label>
                            <div class="uk-form-controls">
                                <input type="date" class="uk-input" id="class_end_date" name="class_end_date" value="{{ old('class_end_date') ?? $lesson->class_end_date->format('Y-m-d') }}" required>
                            </div>
                        </div>

                        <div class="uk-margin uk-width-1-1@s">
                            <label class="uk-form-label uk-heading-bullet" for="class_start_time">Start Time</label>
                            <div class="uk-form-controls">
                                <input type="time" class="uk-input" id="class_start_time" name="class_start_time" value="{{ old('class_start_time') ?? $lesson->class_start_time->format('H:i') }}" required>
                            </div>
                        </div>

                        <div class="uk-margin uk-width-1-1@s">
                            <label class="uk-form-label uk-heading-bullet" for="class_end_time">End Time</label>
                            <div class="uk-form-controls">
                                <input type="time" class="uk-input" id="class_end_time" name="class_end_time" value="{{ old('class_end_time') ?? $lesson->class_end_time->format('H:i') }}" required>
                            </div>
                        </div>


                        <div class="uk-margin uk-width-1-1@s">
                            <label class="uk-form-label uk-heading-bullet">Days of the Week</label>
                            <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                                <label><input class="uk-checkbox" name="monday" type="checkbox" {{in_array('Monday', $daysOfTheWeekArray) ? 'checked' : '' }}>Monday</label>
                                <label><input class="uk-checkbox" name="tuesday" type="checkbox" {{in_array('Tuesday', $daysOfTheWeekArray) ? 'checked' : '' }}>Tuesday</label>
                                <label><input class="uk-checkbox" name="wednesday" type="checkbox" {{in_array('Wednesday', $daysOfTheWeekArray) ? 'checked' : '' }}>Wednesday</label>
                                <label><input class="uk-checkbox" name="thursday" type="checkbox" {{in_array('Thursday', $daysOfTheWeekArray) ? 'checked' : '' }}>Thursday</label>
                                <label><input class="uk-checkbox" name="friday" type="checkbox" {{in_array('Friday', $daysOfTheWeekArray) ? 'checked' : '' }}>Friday</label>
                                <label><input class="uk-checkbox" name="saturday" type="checkbox" {{in_array('Saturday', $daysOfTheWeekArray) ? 'checked' : '' }}>Saturday</label>
                                <label><input class="uk-checkbox" name="sunday" type="checkbox" {{in_array('Sunday', $daysOfTheWeekArray) ? 'checked' : '' }}>Sunday</label>
                            </div>
                        </div>

                        <p uk-margin>
                            <button type="submit" class="uk-button uk-button-primary">Update Lesson</button>
                            <a href="/lesson/{{$lesson->id}}" class="uk-button uk-button-secondary">Cancel</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

