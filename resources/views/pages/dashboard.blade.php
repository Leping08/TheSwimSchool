@extends('layouts.app-uikit')

@section('seo')
    <title>The Swim School Dashboard</title>
    <meta name="description" content="Meta Here."/>
@endsection

@section('heading')
Dashboard
@endsection

@section('content')
<div class="uk-section-muted uk-section-overlap uk-section">
    <div class="uk-container">

        <div class="uk-grid-margin uk-grid" uk-grid="">
            <div class="uk-width-expand@m uk-grid-item-match uk-first-column">
                <div class="uk-margin uk-text-left@s uk-text-center uk-card uk-card-default uk-card-hover uk-scrollspy-inview uk-animation-slide-top-medium" uk-scrollspy-class="">
                    <div class="uk-card-header">
                        <h3 class="el-title uk-margin uk-h2">New Swimmers</h3>
                    </div>
                    <div class="uk-card-body">
                        <ul class="uk-list uk-list-striped">
                            <li><strong>Swimmers</strong></li>
                            @foreach ($swimmers as $swimmer)
                            <li><a href="/swimmers/{{{$swimmer->id}}}" class="list-group-item list-group-item-action justify-content-between">
                                {{$swimmer->firstName}} {{$swimmer->lastName}}
                            </a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="uk-card-footer">
                        <a href="/swimmers" class="uk-button uk-button-primary">All Swimmers</a>
                    </div>
                </div>
            </div>
            <div class="uk-width-expand@m uk-grid-item-match uk-first-column">
                <div class="uk-margin uk-text-left@s uk-text-center uk-card uk-card-default uk-card-hover uk-scrollspy-inview uk-animation-slide-top-medium" uk-scrollspy-class="">
                    <div class="uk-card-header">
                        <h3 class="el-title uk-margin uk-h2">Leads</h3>
                    </div>
                    <div class="uk-card-body">
                        @if(count($leads))
                            <ul class="uk-list uk-list-striped">
                                <li><strong>Leads</strong></li>
                                @foreach ($leads as $lead)
                                    <li><a href="/lead/{{$lead->id}}" class="list-group-item list-group-item-action justify-content-between">
                                            {{$lead->name}}
                                        </a></li>
                                @endforeach
                            </ul>
                            {{ $leads->links() }}
                        @else
                            No leads.
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="uk-grid-margin uk-grid" uk-grid="">
            <div class="uk-width-expand@m uk-grid-item-match uk-first-column">
                <div class="uk-margin uk-text-left@s uk-text-center uk-card uk-card-default uk-card-hover uk-scrollspy-inview uk-animation-slide-top-medium" uk-scrollspy-class="">
                    <div class="uk-card-header">
                        <h3 class="el-title uk-margin uk-h2">Lessons</h3>
                    </div>
                    <div class="uk-card-body">
                        <ul uk-tab>
                            <li><a href="#">View</a></li>
                            <li><a href="#">Add</a></li>
                        </ul>

                        <ul class="uk-switcher uk-margin">
                            <li>
                                @if(count($lessons))
                                    <ul class="uk-list uk-list-striped">
                                        <li><strong>Levels</strong></li>
                                        @foreach ($lessons as $lesson)
                                            <li><a href="/lesson/{{$lesson->id}}" class="list-group-item list-group-item-action justify-content-between">
                                                    {{$lesson->group->type}}
                                                </a></li>
                                        @endforeach
                                    </ul>
                                @else
                                    No lessons.
                                @endif
                            </li>
                            <!-- Lesson -->
                            <li>
                            <form class="uk-grid-small" uk-grid action="/lesson" method="POST">
                                {{ csrf_field() }}

                                <div class="uk-margin uk-width-1-1@s">
                                    <label class="uk-form-label uk-heading-bullet" for="group_id">Level</label>
                                    <div class="uk-form-controls">
                                        <select class="uk-select" name="group_id" id="group_id">
                                            @foreach($groups as $group)
                                                <option value="{{$group->id}}">{{$group->type}} ({{$group->ages}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="uk-margin uk-width-1-1@s">
                                    <label class="uk-form-label uk-heading-bullet" for="location_id">Location</label>
                                    <div class="uk-form-controls">
                                        <select class="uk-select" name="location_id" id="location_id">
                                            @foreach($locations as $location)
                                                <option value="{{$location->id}}">{{$location->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="uk-margin uk-width-1-1@s">
                                    <label class="uk-form-label uk-heading-bullet" for="price">Price</label>
                                    <div class="uk-form-controls">
                                        <input type="number" class="uk-input" id="price" name="price" placeholder="$60" value="{{ old('price') }}" required>
                                    </div>
                                </div>

                                <div class="uk-margin uk-width-1-1@s">
                                    <label class="uk-form-label uk-heading-bullet" for="class_size">Class Size</label>
                                    <div class="uk-form-controls">
                                        <input type="number" class="uk-input" id="class_size" name="class_size" placeholder="10" value="{{ old('class_size') }}" required>
                                    </div>
                                </div>

                                <div class="uk-margin uk-width-1-1@s">
                                    <label class="uk-form-label uk-heading-bullet" for="registration_open">Registration Opens</label>
                                    <div class="uk-form-controls">
                                        <input type="date" class="uk-input" id="registration_open" name="registration_open" placeholder="10" value="{{ old('registration_open') }}" required>
                                    </div>
                                </div>

                                <div class="uk-margin uk-width-1-1@s">
                                    <label class="uk-form-label uk-heading-bullet" for="class_start_date">Start Date</label>
                                    <div class="uk-form-controls">
                                        <input type="date" class="uk-input" id="class_start_date" name="class_start_date" value="{{ old('class_start_date') }}" required>
                                    </div>
                                </div>

                                <div class="uk-margin uk-width-1-1@s">
                                    <label class="uk-form-label uk-heading-bullet" for="class_end_date">End Date</label>
                                    <div class="uk-form-controls">
                                        <input type="date" class="uk-input" id="class_end_date" name="class_end_date" placeholder="10" value="{{ old('class_end_date') }}" required>
                                    </div>
                                </div>

                                <div class="uk-margin uk-width-1-1@s">
                                    <label class="uk-form-label uk-heading-bullet" for="class_start_time">Start Time</label>
                                    <div class="uk-form-controls">
                                        <input type="time" class="uk-input" id="class_start_time" name="class_start_time" value="{{ old('class_start_time') }}" required>
                                    </div>
                                </div>

                                <div class="uk-margin uk-width-1-1@s">
                                    <label class="uk-form-label uk-heading-bullet" for="class_end_time">End Time</label>
                                    <div class="uk-form-controls">
                                        <input type="time" class="uk-input" id="class_end_time" name="class_end_time" value="{{ old('class_end_time') }}" required>
                                    </div>
                                </div>

                                <div class="uk-margin uk-width-1-1@s">
                                    <label class="uk-form-label uk-heading-bullet">Days of the Week</label>
                                    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                                        <label><input class="uk-checkbox" name="monday" type="checkbox">Monday</label>
                                        <label><input class="uk-checkbox" name="tuesday" type="checkbox">Tuesday</label>
                                        <label><input class="uk-checkbox" name="wednesday" type="checkbox">Wednesday</label>
                                        <label><input class="uk-checkbox" name="thursday" type="checkbox">Thursday</label>
                                        <label><input class="uk-checkbox" name="friday" type="checkbox">Friday</label>
                                        <label><input class="uk-checkbox" name="saturday" type="checkbox">Saturday</label>
                                        <label><input class="uk-checkbox" name="sunday" type="checkbox">Sunday</label>
                                    </div>
                                </div>

                                <p uk-margin>
                                    <button type="submit" class="uk-button uk-button-primary">Add Lesson</button>
                                </p>
                            </form>
                        </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="uk-grid-margin uk-grid" uk-grid="">
            <div class="uk-width-expand@m uk-grid-item-match uk-first-column">
                <div class="uk-margin uk-text-left@s uk-text-center uk-card uk-card-default uk-card-hover uk-scrollspy-inview uk-animation-slide-top-medium" uk-scrollspy-class="">
                    <div class="uk-card-header">
                        <h3 class="el-title uk-margin uk-h2">Swimmer Levels</h3>
                    </div>
                    <div class="uk-card-body">
                        <ul uk-tab>
                            <li><a href="#">View</a></li>
                            <li><a href="#">Add</a></li>
                        </ul>

                        <ul class="uk-switcher uk-margin">
                            <li>
                                @if(count($groups))
                                    <ul class="uk-list uk-list-striped">
                                        <li><strong>Levels</strong></li>
                                        @foreach ($groups as $group)
                                            <li><a href="/groups/{{{$group->id}}}" class="list-group-item list-group-item-action justify-content-between">
                                                    {{$group->type}}
                                                </a></li>
                                        @endforeach
                                    </ul>
                                @else
                                    No groups.
                                @endif
                            </li>
                            <li>
                                <!-- Swimmer Level -->
                                <form class="uk-grid-small" uk-grid action="/groups" method="POST">
                                    {{ csrf_field() }}
                                    <div class="uk-margin uk-width-1-1@s">
                                        <label class="uk-form-label uk-heading-bullet" for="name">Type</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" id="type" name="type" placeholder="Parent and Toddler Aquatics Program" value="{{ old('name') }}" required>
                                        </div>
                                    </div>

                                    <div class="uk-margin uk-width-1-1@s">
                                        <label class="uk-form-label uk-heading-bullet" for="name">Ages</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" id="ages" name="ages" placeholder="12-36 Months" value="{{ old('name') }}" required>
                                        </div>
                                    </div>

                                    <div class="uk-margin uk-width-1-1@s">
                                        <label class="uk-form-label uk-heading-bullet" for="name">Description</label>
                                        <div class="uk-form-controls">
                                            <textarea class="uk-textarea" id="description" name="description" rows="4" placeholder="A water adjustment course where toddlers learn basic water skills through songs and structured......"></textarea>
                                        </div>
                                    </div>

                                    <p uk-margin>
                                        <button type="submit" class="uk-button uk-button-primary">Add Level</button>
                                    </p>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="uk-width-expand@m uk-grid-item-match uk-first-column">
                <div class="uk-margin uk-text-left@s uk-text-center uk-card uk-card-default uk-card-hover uk-scrollspy-inview uk-animation-slide-top-medium" uk-scrollspy-class="">
                    <div class="uk-card-header">
                        <h3 class="el-title uk-margin uk-h2">Locations</h3>
                    </div>
                    <div class="uk-card-body">
                        <ul uk-tab>
                            <li><a href="#">View</a></li>
                            <li><a href="#">Add</a></li>
                        </ul>

                        <ul class="uk-switcher uk-margin">
                            <li>
                                @if(count($locations))
                                    <ul class="uk-list uk-list-striped">
                                        <li><strong>Locations</strong></li>
                                        @foreach ($locations as $location)
                                            <li><a href="/locations/{{$location->id}}" class="list-group-item list-group-item-action justify-content-between">
                                                    {{$location->name}}
                                                </a></li>
                                        @endforeach
                                    </ul>
                                @else
                                    No locations.
                                @endif
                            </li>
                            <li>
                                <!-- Location -->
                                <form class="uk-grid-small" uk-grid action="/locations" method="POST">
                                    {{ csrf_field() }}
                                    <div class="uk-margin uk-width-1-1@s">
                                        <label class="uk-form-label uk-heading-bullet" for="name">Name</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" id="name" name="name" placeholder="Name" value="{{ old('name') }}" required>
                                        </div>
                                    </div>

                                    <div class="uk-margin uk-width-1-1@s">
                                        <label class="uk-form-label uk-heading-bullet" for="street">Street</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" id="street" name="street" placeholder="12345 Street Address" value="{{ old('street') }}" required>
                                        </div>
                                    </div>

                                    <div class="uk-margin uk-width-1-1@s">
                                        <label class="uk-form-label uk-heading-bullet" for="city">City</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" id="city" name="city" placeholder="City" value="{{ old('city') }}" required>
                                        </div>
                                    </div>

                                    <div class="uk-margin uk-width-1-1@s">
                                        <label class="uk-form-label uk-heading-bullet" for="state">State</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" id="state" name="state" placeholder="FL" value="{{ old('state') }}" required>
                                        </div>
                                    </div>

                                    <div class="uk-margin uk-width-1-1@s">
                                        <label class="uk-form-label uk-heading-bullet" for="zip">Zip</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" id="zip" name="zip" placeholder="12345" value="{{ old('zip') }}" required>
                                        </div>
                                    </div>

                                    <div class="uk-margin uk-width-1-1@s">
                                        <label class="uk-form-label uk-heading-bullet" for="phoneNumber">Phone</label>
                                        <div class="uk-form-controls">
                                            <input type="text" class="uk-input" id="phoneNumber" name="phoneNumber" placeholder="941-999-9999" value="{{ old('phoneNumber') }}" required>
                                        </div>
                                    </div>

                                    <p uk-margin>
                                        <button type="submit" class="uk-button uk-button-primary">Add Location</button>
                                    </p>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-grid-margin uk-grid" uk-grid="">

            <div class="uk-width-expand@m uk-grid-item-match uk-first-column">
                <div class="uk-margin uk-text-left@s uk-text-center uk-card uk-card-default uk-card-hover uk-scrollspy-inview uk-animation-slide-top-medium" uk-scrollspy-class="">
                    <div class="uk-card-header">
                        <h3 class="el-title uk-margin uk-h2">Today's Lessons</h3>
                    </div>
                    <!-- TODO: Make today's lessons show today's lessons -->
                    <div class="uk-card-body">
                        @if(count($todaysLessons))
                            <ul class="uk-list uk-list-striped">
                                <li><strong>Lessons</strong></li>
                                @foreach ($todaysLessons as $lesson)
                                    <li><a href="/lesson/{{$lesson->id}}" class="list-group-item list-group-item-action justify-content-between">
                                            {{$lesson->group->type}}
                                        </a></li>
                                @endforeach
                            </ul>
                        @else
                            No lessons today.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

