@extends('layouts.app-uikit')

@section('seo')
    <title>The Swim School | Parrish Swimming Lessons | Email Unsubscribe</title>
    <meta name="description" content="We're sorry to see you go! For more information on Parrish swimming lessons and The Swim School, please give us a call at {{ config('contact.phone.number') }}."/>
@endsection

@section('heading')
We're Sorry to See You Go
@endsection

@section('content')
    <div class="uk-section-default uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-grid-margin uk-grid" uk-grid="">
                <div class="uk-width-4-4@m uk-first-column">
                    The email address {{$email}} has been unsubscribed from all marketing emails from <a title="Manatee County Swim Lessons" href="{{ route('home.index') }}">The Swim School</a>.
                </div>
            </div>
        </div>
    </div>
@endsection