@extends('layouts.app-uikit')

@section('seo')
    <title>Bradenton Private Swim Lessons | Parrish Swim Instructors | Ellenton</title>
    <meta name="description" content="Our Ellenton and Parrish swim instructors at The Swim School are available to help you achieve your swimming goals! Request your Bradenton private swim lessons here."/>
@endsection

@section('heading')
    Home Private Lessons
@endsection

@section('content')
    <div class="uk-section-default uk-section uk-section-small">
        <div class="uk-container">
            @if($banner && $banner->active)
                <div class="uk-alert-primary" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    {!! $banner->text !!}
                </div>
            @endif

            <div class="uk-grid-margin uk-margin-large-top">
                <div class="uk-width-4-4@m uk-first-column">
                    <h2 class="uk-heading-bullet">Request Private Lessons at Home</h2>
                </div>

                <p>Home and community pool private lessons within the Parrish, Ellenton, and Palmetto areas are also available.</p>

                <div class="uk-grid-margin uk-grid" uk-grid="">
                    <div class="uk-width-4-4@m uk-first-column">
                        <h3 class="uk-heading-bullet">Private Lesson Package Options</h3>
                        <p class="uk-text-meta">Private lessons are conducted one-on-one with an instructor.</p>
                        <div class="uk-child-width-1-2@m uk-grid-small uk-grid-match" uk-grid>
                            <div>
                                <div class="uk-card uk-card-default uk-card-body">
                                    <h5>Four 30 Minute Lessons Per Month (1x/week)</h5>
                                    <ul class="uk-list uk-list-bullet">
                                        <li>Our Pool = $140 per Student</li>
                                        <li>Your Pool = $200 per Student</li>
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <div class="uk-card uk-card-default uk-card-body">
                                    <h5>Eight 30 Minute Lessons Per Month (2x/week)</h5>
                                    <ul class="uk-list uk-list-bullet">
                                        <li>Our Pool = $280 per Student</li>
                                        <li>Your Pool = $400 per Student</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="uk-width-4-4@m uk-first-column">
                        <h3 class="uk-heading-bullet">Semi-Private Lesson Package Options</h3>
                        <p class="uk-text-meta">Semi-Private lessons can be requested if you have siblings or friends close in age and ability level who would like to receive swim instruction together.</p>
                        <div class="uk-child-width-1-2@m uk-grid-small uk-grid-match" uk-grid>
                            <div>
                                <div class="uk-card uk-card-default uk-card-body">
                                    <h5>Four 30 Minute Lessons Per Month (1x/week)</h5>
                                    <ul class="uk-list uk-list-bullet">
                                        <li>Our Pool = $80 per Student</li>
                                        <li>Your Pool = $120 per Student</li>
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <div class="uk-card uk-card-default uk-card-body">
                                    <h5>Eight 30 Minute Lessons Per Month (2x/week)</h5>
                                    <ul class="uk-list uk-list-bullet">
                                        <li>Our Pool = $160 per Student</li>
                                        <li>Your Pool = $240 per Student</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(config('season.private.season'))
                    <p>Please provide as much info as possible so we can provide you details regarding private lessons at your home or community pool.</p>

                    <div class="uk-child-width-1-1@m uk-grid-small uk-grid-match" uk-grid>
                        <div class="uk-card uk-card-default uk-card-body">
                            <form action="{{ route('home_privates.store') }}" method="post">
                                {{ csrf_field() }}
                                <div class="uk-margin">
                                    <label class="uk-form-label uk-heading-bullet" for="">Swimmer Name</label>
                                    <div class="uk-form-controls">
                                        <input type="text" name="swimmer_name" value="{{ old('swimmer_name') }}" class="uk-input" placeholder="Full Name" required>
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label uk-heading-bullet" for="">Swimmer Birth Date</label>
                                    <div class="uk-form-controls">
                                        <input type="date" class="uk-input" id="swimmer_birth_date" name="swimmer_birth_date" value="{{ old('swimmer_birth_date') }}" required>
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label uk-heading-bullet" for="">Email</label>
                                    <div class="uk-form-controls">
                                        <input type="email" name="email" value="{{ old('email') }}" class="uk-input" placeholder="Email@email.com" required>
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label uk-heading-bullet" for="">Phone</label>
                                    <div class="uk-form-controls">
                                        <input type="tel" name="phone" value="{{ old('phone') }}" class="uk-input" placeholder="999 999-9999" required>
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label uk-heading-bullet" for="">Type</label>
                                    <div class="uk-form-controls">
                                        <select class="uk-select" name="type" id="type">
                                            <option value="Private Lesson">Private Lesson (One Swimmer)</option>
                                            <option value="Semi Private Lesson">Semi Private Lesson (Multiple Swimmers)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label uk-heading-bullet" for="">Package Option</label>
                                    <div class="uk-form-controls">
                                        <select class="uk-select" name="length" id="length">
                                            <option value="4 Lessons Per Month">4 Lessons Per Month</option>
                                            <option value="8 Lessons Per Month">8 Lessons Per Month</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label uk-heading-bullet" for="">Address</label>
                                    <div class="uk-form-controls">
                                        <input type="text" name="address" value="{{ old('address') }}" class="uk-input" placeholder="12345 Street Lakewood Ranch, FL 34202" required>
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label uk-heading-bullet" for="">Provide us with your availability</label>
                                    <div class="uk-form-controls">
                                        <textarea name="availability" rows="5" class="uk-textarea" placeholder="Example: I am available Monday from 8am-1pm and Wednesday from 5-9pm." required>{{ old('availability') }}</textarea>
                                    </div>
                                </div>
                                <div uk-grid="" class="uk-grid">
                                    <div class="uk-width-1-2@s uk-margin">
                                        <input type="submit" value="Send" class="uk-button-primary uk-button uk-button-large">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection