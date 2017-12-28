@extends('layouts.app-uikit')

@section('heading')
    {{$lead->name}}
@endsection

@section('content')

    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-card uk-card-default uk-width-1-1@s">
                @if(count($lead))
                    <div class="uk-card-body">
                        <h4>Lead Info</h4>
                        <dl class="uk-description-list-horizontal">
                            <dt>Id:</dt>
                            <dd>{{$lead->id}}</dd>

                            <dt>Name:</dt>
                            <dd>{{$lead->name}}</dd>

                            <dt>Email:</dt>
                            <dd>{{$lead->email}}</dd>

                            <dt>Phone:</dt>
                            <dd>{{$lead->phone}}</dd>

                            <dt>Received:</dt>
                            <dd>{{$lead->created_at->format('m/d/Y g:i a')}}</dd>

                            <dt>Type:</dt>
                            <dd>{{$lead->type->name}}</dd>

                            <dt>Message:</dt>
                            <dd>{{$lead->message}}</dd>

                            <!-- TODO: Add notes field to leads -->
                        </dl>
                    </div>
                    <div class="uk-card-footer">
                        <!--<a class="uk-button uk-button-primary" href="/lead/{{{$lead->id}}}/edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>-->
                        <!-- TODO: Implement a followed up bool to leads -->
                        <a class="uk-button uk-button-default" disabled><i class="fa fa-check" aria-hidden="true"></i> Followed Up Coming Soon</a>
                    </div>
                @else
                    <div class="uk-card-body">
                        We cant find that lead.
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

