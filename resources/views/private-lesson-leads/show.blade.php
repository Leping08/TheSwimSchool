@extends('layouts.app-uikit')

@section('heading')
    {{$lead->name}}
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-card uk-card-default uk-width-1-1@s">
                <div class="uk-card-body">
                    <h4>Private Lesson Lead Info</h4>
                    <dl class="uk-description-list-horizontal">
                        <dt>Id:</dt>
                        <dd>{{$lead->id}}</dd>

                        <dt>Name:</dt>
                        <dd>{{$lead->name}}</dd>

                        <dt>Email:</dt>
                        <dd>{{$lead->email}}</dd>

                        <dt>Phone:</dt>
                        <dd>{{$lead->phone}}</dd>

                        <dt>Type:</dt>
                        <dd>{{$lead->type}}</dd>

                        <dt>Length:</dt>
                        <dd>{{$lead->length}}</dd>

                        <dt>Location:</dt>
                        <dd>{{$lead->location}}</dd>

                        <dt>Received:</dt>
                        <dd>{{$lead->created_at->format('m/d/Y g:i a')}}</dd>

                        <dt>Availability:</dt>
                        <dd>{{$lead->availability}}</dd>
                    </dl>
                </div>
                <div class="uk-card-footer">
                    <!-- TODO: Implement a followed up bool to leads -->
                    <a class="uk-button uk-button-default" disabled><i class="fa fa-check" aria-hidden="true"></i> Followed Up Coming Soon</a>
                </div>
            </div>
        </div>
    </div>
@endsection
