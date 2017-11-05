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
                                {{$swimmer->name}}                               
                            </a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="uk-card-footer">
                        <a href="/swimmers" class="uk-button uk-button-primary">All Swimmers</a>
                    </div>
                </div>
            </div>
            <div class="uk-width-expand@m uk-grid-item-match">
                <div class="uk-margin uk-text-left@s uk-text-center uk-card uk-card-default uk-card-hover uk-scrollspy-inview uk-animation-slide-top-medium" uk-scrollspy-class="">
                    <div class="uk-card-header">
                        <h3 class="el-title uk-margin uk-h2">Today's Lessons</h3>
                    </div>
                    <div class="uk-card-body">
                        @if(count($todaysLessons))
                        <ul class="uk-list uk-list-striped">
                            <li><strong>Lessons</strong></li>
                            @foreach ($todaysLessons as $lesson)
                                <li><a href="/lesson/{{{$lesson->id}}}" class="list-group-item list-group-item-action justify-content-between">
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

        <div class="uk-grid-margin uk-grid" uk-grid="">
            <div class="uk-width-expand@m uk-grid-item-match uk-first-column">
                <div class="uk-margin uk-text-left@s uk-text-center uk-card uk-card-default uk-card-hover uk-scrollspy-inview uk-animation-slide-top-medium" uk-scrollspy-class="">
                    <div class="uk-card-header">
                        <h3 class="el-title uk-margin uk-h2">New</h3>
                    </div>
                    <div class="uk-card-body">
                        <div uk-grid>
                            <div class="uk-width-auto@m">
                                <ul class="uk-tab-left" uk-tab="connect: #component-tab-left; animation: uk-animation-fade">
                                    <li><a href="#">Swimmer Level</a></li>
                                    <li><a href="#">Lesson</a></li>
                                    <li><a href="#">Location</a></li>
                                </ul>
                            </div>
                            <div class="uk-width-expand@m">
                                <ul id="component-tab-left" class="uk-switcher">
                                    <li>
                                        <form class="uk-grid-small" uk-grid action="/add/group/" method="POST">
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
                                    <li>
                                        <form class="uk-grid-small" uk-grid action="/" method="POST">
                                            {{ csrf_field() }}
                                            <div class="uk-margin uk-width-1-1@s">
                                                <label class="uk-form-label uk-heading-bullet" for="name">Swimmer Name</label>
                                                <div class="uk-form-controls">
                                                    <input type="text" class="uk-input" id="name" name="name" placeholder="Name" value="{{ old('name') }}" required>
                                                </div>
                                            </div>
                                        </form>
                                    </li>
                                    <li>
                                        <form class="uk-grid-small" uk-grid action="/add/location/" method="POST">
                                            {{ csrf_field() }}
                                            <div class="uk-margin uk-width-1-1@s">
                                                <label class="uk-form-label uk-heading-bullet" for="name">Name</label>
                                                <div class="uk-form-controls">
                                                    <input type="text" class="uk-input" id="name" name="name" placeholder="Name" value="{{ old('name') }}" required>
                                                </div>
                                            </div>

                                            <div class="uk-margin uk-width-1-1@s">
                                                <label class="uk-form-label uk-heading-bullet" for="name">Street</label>
                                                <div class="uk-form-controls">
                                                    <input type="text" class="uk-input" id="street" name="street" placeholder="12345 Street Address" value="{{ old('name') }}" required>
                                                </div>
                                            </div>

                                            <div class="uk-margin uk-width-1-1@s">
                                                <label class="uk-form-label uk-heading-bullet" for="name">City</label>
                                                <div class="uk-form-controls">
                                                    <input type="text" class="uk-input" id="city" name="city" placeholder="City" value="{{ old('name') }}" required>
                                                </div>
                                            </div>

                                            <div class="uk-margin uk-width-1-1@s">
                                                <label class="uk-form-label uk-heading-bullet" for="name">State</label>
                                                <div class="uk-form-controls">
                                                    <input type="text" class="uk-input" id="state" name="state" placeholder="FL" value="{{ old('name') }}" required>
                                                </div>
                                            </div>

                                            <div class="uk-margin uk-width-1-1@s">
                                                <label class="uk-form-label uk-heading-bullet" for="name">Zip</label>
                                                <div class="uk-form-controls">
                                                    <input type="text" class="uk-input" id="zip" name="zip" placeholder="12345" value="{{ old('name') }}" required>
                                                </div>
                                            </div>

                                            <div class="uk-margin uk-width-1-1@s">
                                                <label class="uk-form-label uk-heading-bullet" for="name">Phone</label>
                                                <div class="uk-form-controls">
                                                    <input type="text" class="uk-input" id="phoneNumber" name="phoneNumber" placeholder="941-999-9999" value="{{ old('name') }}" required>
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
            </div>
        </div>
    </div>
</div>
@endsection

