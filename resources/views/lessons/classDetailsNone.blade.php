@extends('layouts.app-uikit')

@section('heading')
Lessons
@endsection

@section('content')
<div class="uk-section-default uk-section-overlap uk-section">
    <div class="uk-container">
        <div class="uk-card uk-card-default">
            <div class="uk-card-header">
                <h3 class="uk-heading-bullet">Sorry No Classes Available At This Time</h3>
            </div>
            <div class="uk-card-body">
                <div class="card-text">
                    <p>Check back soon or sign up for a <a href="/lessons">different lesson</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

