@extends('layouts.app-uikit')

@section('heading')
Lifeguarding
@endsection

@section('content')
<div class="uk-section-default uk-section uk-section-small">
    <div class="uk-container">
        <div class="uk-grid-margin uk-grid" uk-grid="">
            <div class="uk-width-3-4@m uk-first-column">
                <div class="uk-margin uk-dropcap">
                    Hire The Swim School to supervise your next pool party or event by the water. We have certified lifeguards to keep everyone safe while you enjoy the party! We can even provide extra fun with pool games for a small additional cost.</div>
                <div class="uk-margin uk-text-center uk-grid-match uk-child-width-1-1 uk-child-width-1-2@m uk-grid" uk-grid="">
                    <div class="uk-first-column">
                        <div class="el-item uk-panel">
                            <span uk-icon="icon: lifesaver;ratio: 2" class="el-image uk-icon"></span>
                            <h3 class="el-title uk-margin uk-heading-bullet">Supervision Only: $15/hr</h3>
                        </div>
                    </div>
                    <div>
                        <div class="el-item uk-panel">
                            <span uk-icon="icon: lifesaver;ratio: 2" class="el-image uk-icon"></span>
                            <h3 class="el-title uk-margin uk-heading-bullet">Supervision and Pool Games: $20/hr</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-expand@m">
                <div class="uk-margin">
                    <img src="http://theswimschool.deltavcreative.com/wp-content/uploads/150712-F-SN009-010.jpg" class="el-image uk-border-rounded uk-box-shadow-large" alt="">
                </div>
            </div>
        </div>

        <div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid="">
            <div class="uk-width-1-1@m uk-first-column">
                <div class="uk-margin uk-scrollspy-inview uk-animation-slide-bottom-medium" uk-scrollspy-class="">
                    <div class="uk-card uk-card-default uk-card-body">
                        <div class="uk-h2">Book A Lifeguard</div>
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
                                        <textarea name="message" rows="5" class="uk-textarea" placeholder="I would like to request a Request a lifeguard for my party..." required>{{ old('message') }}</textarea>
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

