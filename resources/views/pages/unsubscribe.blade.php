@extends('layouts.app-uikit')

@section('seo')
    <title></title>
    <meta name="description" content=""/>
@endsection

@section('heading')
We’re Sorry to See You Go
@endsection

@section('content')
    <div class="uk-section-default uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-grid-margin uk-grid" uk-grid="">
                <div class="uk-width-4-4@m uk-first-column">
                    The email address {{$email}} has been unsubscribed from all marketing emails from The Swim School.
                    {{--TODO: If this was a mistake <a href="/re-subscribe">re-subscribe me</a>!--}}
                </div>
            </div>
        </div>
    </div>
@endsection