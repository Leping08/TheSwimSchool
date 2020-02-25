@extends('layouts.app-uikit')

@section('seo')
    <title>Parrish Swim Lessons | Lakewood Ranch Swimming Classes | The Swim School</title>
    <meta name="description" content="The Swim School near Lakewood Ranch & Parrish is proud to offer private and semi-private swim lessons, as well as group swimming classes! Visit our website for more information."/>
@endsection

@section('heading')
    Private Calendar
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <private-calendar events="{{ json_encode($events) }}"></private-calendar>
        </div>
    </div>
@endsection

