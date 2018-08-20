@extends('layouts.app-uikit')

@section('seo')
    <!-- TODO: SEO swim team roster page -->
    <title></title>
    <meta name="description" content=""/>
@endsection

@section('heading')
    North River Swim Team Roster
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <swim-team-roster :levels="{{json_encode($levels)}}" :seasons="{{json_encode($seasons)}}"></swim-team-roster>
        </div>
    </div>
@endsection

