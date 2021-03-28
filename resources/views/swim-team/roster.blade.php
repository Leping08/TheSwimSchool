@extends('layouts.app-uikit')

@section('seo')
    <title>Parrish Bull Sharks | Swim Team Roster | Group Swimming near Bradenton</title>
    <meta name="description" content="Check out the Parrish Bull Sharks Swim Team roster here. The Swim School is so proud of our athletes. For more information on group swimming near Bradenton, reach out to us today."/>
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

