@extends('layouts.app-uikit')

@section('heading')
Lessons
@endsection

@section('content')
<div class="uk-section-default uk-section-overlap uk-section">
    <div class="uk-container">
    @foreach($lessons as $lesson)
    <div class="uk-margin-top">
        <div class="uk-card uk-card-default uk-width-1-1@s" uk-scrollspy="cls: uk-animation-slide-bottom; delay: 250">
            <div class="uk-card-header">
                <div class="uk-grid-small uk-flex-middle" uk-grid>
                    <div class="uk-width-expand">
                        <div class="uk-card-badge uk-label">{{$lesson->ages}}</div>
                        <h3 class="uk-card-title f-24 uk-heading-bullet">{{$lesson->class_type}}</h3>
                    </div>
                </div>
            </div>
            <div class="uk-card-body">
                <p>{{$lesson->description}}</p>
            </div>
            <div class="uk-card-footer">
                <a href="/lessons/{{{$lesson->class_type}}}" class="uk-button uk-button-primary">Find Classes</a>
            </div>
        </div>
    </div>
    @endforeach
    </div>
</div>
@endsection
