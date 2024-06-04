@extends('layouts.app-uikit')

@section('seo')
    <title>Realhab Attandance</title>
    <meta name="description" content="Realhab Attandance"/>
@endsection

@section('heading')
    Realhab Attandance
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <realhab-attendance :swimmers="{{json_encode($swimmers)}}" :sessions="{{json_encode($sessions)}}"></realhab-attendance>
        </div>
    </div>
@endsection
