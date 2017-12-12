@extends('layouts.app-uikit')

@section('seo')
    <title>Contact The Swim School</title>
    <meta name="description" content="Meta Here."/>
@endsection

@section('heading')
Contact Us
@endsection

@section('content')
<div class="uk-section-default uk-section-overlap uk-section" uk-scrollspy="{&quot;target&quot;:&quot;[uk-scrollspy-class]&quot;,&quot;cls&quot;:&quot;uk-animation-slide-bottom-medium&quot;,&quot;delay&quot;:false}">
    <div class="uk-container">
        <div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid="">
            <div class="uk-width-1-1@m uk-first-column">
                <div class="uk-margin uk-scrollspy-inview uk-animation-slide-bottom-medium" uk-scrollspy-class="">
                    <div class="uk-card uk-card-default uk-card-body">
                        <div class="uk-h2">Send us a message</div>
                            <form action="" method="post">
                                {{ csrf_field() }}
                                <div class="uk-margin">
                                    <label class="uk-form-label uk-heading-bullet" for="">Name</label>
                                    <div class="uk-form-controls">
                                        <input type="text" name="name" value="{{ old('name') }}" class="uk-input" placeholder="Full Name" required>
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
                                    <label class="uk-form-label uk-heading-bullet" for="">Message</label>
                                    <div class="uk-form-controls">
                                        <textarea name="message" rows="5" class="uk-textarea" placeholder="Your Message" required>{{ old('message') }}</textarea>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



