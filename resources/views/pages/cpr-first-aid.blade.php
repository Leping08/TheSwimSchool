@extends('layouts.app-uikit')

@section('seo')
    <title>About The Swim School</title>
    <meta name="description" content="Meta Here."/>
@endsection

@section('heading')
    CPR and First Aid Training
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-grid-margin uk-grid" uk-grid="">
                <div class="uk-width-3-4@m uk-first-column">
                    <div class="uk-margin uk-dropcap">
                        Need CPR and/or First Aid training? The Swim School can certify you with these life-saving skills. Our instructiors have years of experience teaching people CPR and first aid. Individual and group instruction is available.
                    </div>
                </div>
                <div class="uk-width-1-4@m">
                    <div class="uk-margin">
                        <img src="/img/cpr-first-aid.jpg" class="el-image uk-border-rounded uk-box-shadow-small" alt="Lakewood Ranch CPR training">
                    </div>
                </div>
            </div>

            <div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid="">
                <div class="uk-width-1-1@m uk-first-column">
                    <div class="uk-margin uk-scrollspy-inview uk-animation-slide-bottom-medium" uk-scrollspy-class="">
                        <div class="uk-card uk-card-default uk-card-body">
                            <div class="uk-h2">Schedule Training</div>
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
                                        <textarea name="message" rows="5" class="uk-textarea" placeholder="I would like to schedule CPR and/or First Aid training." required>{{ old('message') }}</textarea>
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

@endsection
