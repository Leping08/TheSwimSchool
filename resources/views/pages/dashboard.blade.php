@extends('layouts.app-uikit')

@section('heading')
Dashboard
@endsection

@section('content')
<div class="uk-section-muted uk-section-overlap uk-section">
    <div class="uk-container">

        <div class="uk-grid-margin uk-grid" uk-grid="">
            <div class="uk-width-expand@m uk-grid-item-match uk-first-column">
                <div class="uk-margin uk-text-left@s uk-text-center uk-card uk-card-default uk-card-hover uk-scrollspy-inview uk-animation-slide-top-medium" uk-scrollspy-class="">
                    <div class="uk-card-header">
                        <h3 class="el-title uk-margin uk-h2">Latest Signups</h3>
                    </div>
                    <div class="uk-card-body">
                        <ul class="uk-list uk-list-striped">
                            <li><strong>Swimmers</strong></li>
                            @foreach ($swimmers as $swimmer)
                            <li><a href="/swimmers/{{{$swimmer->id}}}" class="list-group-item list-group-item-action justify-content-between">
                                {{$swimmer->name}}                               
                            </a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="uk-card-footer">
                        <a href="/swimmers" class="uk-button uk-button-primary">All Swimmers</a>
                    </div>
                </div>
            </div>
            <div class="uk-width-expand@m uk-grid-item-match">
                <div class="uk-margin uk-text-left@s uk-text-center uk-card uk-card-default uk-card-hover uk-scrollspy-inview uk-animation-slide-top-medium" uk-scrollspy-class="">
                    <div class="uk-card-header">
                        <h3 class="el-title uk-margin uk-h2">Today's Lessons</h3>
                    </div>
                    <div class="uk-card-body">
                        @if(count($todaysLessons))
                        <ul class="uk-list uk-list-striped">
                            <li><strong>Swimmers</strong></li>
                            @foreach ($todaysLessons as $lesson)
                                <li><a href="/swimmers/{{{$lesson->id}}}" class="list-group-item list-group-item-action justify-content-between">
                                        {{$lesson->group->type}}
                                    </a></li>
                            @endforeach
                        </ul>
                        @else
                            No lessons today.
                        @endif
                    </div>
                </div>
            </div>
        </div>




    </div>
</div>
@endsection

