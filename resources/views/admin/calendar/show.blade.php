@extends('layouts.app-uikit')

@section('seo')
    <title>TODO</title>
    <meta name="description" content=""/>
@endsection

@section('heading')
    {{$user->name}} Calendar
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <instructor-calendar events="{{ json_encode($events) }}"></instructor-calendar>
        </div>
    </div>
@endsection