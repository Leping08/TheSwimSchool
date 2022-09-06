@extends('layouts.app-uikit')

@section('seo')
    <title>Thank You for Signing Up | Swim Lessons Parrish | Palmetto Sun City Center</title>
    <meta name="description" content="Thank you for signing up for your swim lessons! The Swim School is proud to offer private and group swimming lessons near Parrish, Palmetto, and Sun City Center. See you in the pool!"/>
@endsection

@section('heading')
    Thank You!
@endsection

@section('content')
    <div class="uk-section-default uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-child-width-1-1@s uk-margin-bottom">
                Thank You For Signing Up for the {{config('swim-team.name')}}! You should receive two emails shortly, one containing your transaction receipt and the other with swim information specific to your registration. 
                Please check your Junk and Spam folders for an email from <a href="mailto:info@theswimschoolfl.com">info@theswimschoolfl.com</a> if it does not appear in your inbox. 
                Moving this email to your inbox will allow future emails to be delivered there. We look forward to seeing you in the pool!
            </div>
            <div class="uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid="masonry: true">
                <div>
                    <img alt="Private Swim Lessons Ellenton" class="uk-border-rounded uk-box-shadow-large" src="{{ asset('/img/swim-team/breaststroke.jpg') }}">
                </div>
                <div>
                    <img alt="Parrish Swimming" class="uk-border-rounded uk-box-shadow-large" src="{{ asset('/img/thank-you/breast-stroke.jpg') }}">
                </div>
                <div>
                    <img alt="Child Swim Lesson near Ellenton" class="uk-border-rounded uk-box-shadow-large" src="{{ asset('/img/swim-team/dive-cropped.jpg') }}">
                </div>
                <div>
                    <img alt="Swimming for Kids Parrish" class="uk-border-rounded uk-box-shadow-large" src="{{ asset('/img/swim-team/new-log-cap.jpg') }}">
                </div>
                <div>
                    <img alt="Parrish Swim Team" class="uk-border-rounded uk-box-shadow-large" src="{{ asset('/img/swim-team/backstroke.jpg') }}">
                </div>
                <div>
                    <img alt="Kids Swimming Palmetto" class="uk-border-rounded uk-box-shadow-large" src="{{ asset('/img/thank-you/winner.jpg') }}">
                </div>
            </div>
        </div>
    </div>
@endsection
