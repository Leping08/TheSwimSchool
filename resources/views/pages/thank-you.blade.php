@extends('layouts.app-uikit')

@section('seo')
    <title></title> <!-- TODO: Add SEO to this page -->
    <meta name="description" content=""/>
@endsection

@section('heading')
    Thank You
@endsection

@section('content')
    <div class="uk-section-default uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid="masonry: true">
                <div>
                    <img alt="" class="uk-border-rounded uk-box-shadow-large" src="/img/thank-you/float.jpg">
                </div>
                <div>
                    <img alt="" class="uk-border-rounded uk-box-shadow-large" src="/img/thank-you/breast-stroke.jpg">
                </div>
                <div>
                    <img alt="" class="uk-border-rounded uk-box-shadow-large" src="/img/thank-you/kicking.jpg">
                </div>
                <div>
                    <img alt="" class="uk-border-rounded uk-box-shadow-large" src="/img/thank-you/smile.jpg">
                </div>
                <div>
                    <img alt="" class="uk-border-rounded uk-box-shadow-large" src="/img/thank-you/the-team.jpg">
                </div>
                <div>
                    <img alt="" class="uk-border-rounded uk-box-shadow-large" src="/img/thank-you/winner.jpg">
                </div>
                <div>
                    <img alt="" class="uk-border-rounded uk-box-shadow-large" src="/thank-you/breast-stroke.jpg">
                </div>
            </div>
        </div>
    </div>
@endsection
