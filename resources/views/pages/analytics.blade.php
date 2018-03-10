@extends('layouts.app-uikit')

@section('seo')
    <title>The Swim School Analytics</title>
    <meta name="description" content="Meta Here."/>
@endsection

@section('heading')
    Analytics
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-card uk-card-default uk-width-1-1@s">
                <div class="uk-card-body">
                    {!! $swimmerRegistrations->html() !!}
                </div>
            </div>

            <div class="uk-card uk-card-default uk-width-1-1@s uk-margin-top">
                <div class="uk-card-body">
                    {!! $swimmerRegistrationDays->html() !!}
                </div>
            </div>
            <a href="https://datastudio.google.com/open/17dj-YhyTBpc5Rev_w3puKIfPKBALD6oL" target="_blank" class="uk-button-primary uk-button uk-margin-top">Google Analytics Report</a>
        </div>
    </div>
    {!! Charts::styles() !!}
    {!! Charts::scripts() !!}
    {!! $swimmerRegistrations->script() !!}
    {!! $swimmerRegistrationDays->script() !!}
@endsection