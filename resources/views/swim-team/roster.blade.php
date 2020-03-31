@extends('layouts.app-uikit')

@section('seo')
    <!-- TODO: SEO swim team roster page -->
    <title></title>
    <meta name="description" content=""/>
@endsection

@section('heading')
    {{ config('swim-team.full-name') }} Roster
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <swim-team-roster :levels="{{json_encode($levels)}}" :seasons="{{json_encode($seasons)}}" :currentseason="{{json_encode($currentSeason)}}"></swim-team-roster>
        </div>
    </div>
@endsection

