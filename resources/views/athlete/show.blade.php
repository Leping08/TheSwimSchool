@extends('layouts.app-uikit')

@section('heading')
    {{$athlete->firstName}} {{$athlete->lastName}}
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-card uk-card-default uk-width-1-1@s">
                <div class="uk-card-body">
                    <h4>Athlete Info</h4>
                    <dl class="uk-description-list-horizontal">
                        <dt>Name:</dt>
                        <dd>{{$athlete->firstName}} {{$athlete->lastName}}</dd>

                        <dt>Birth Date:</dt>
                        <dd>{{$athlete->birthDate->toDateString()}}</dd>

                        <dt>Age:</dt>
                        @if($athlete->yearsOld() < 2)
                            <dd>{{$athlete->monthsOld()}} months old</dd>
                        @else
                            <dd>{{$athlete->yearsOld()}} years old</dd>
                        @endif
                        <dt>Email:</dt>
                        <dd><a href="mailto:{{{$athlete->email}}}">{{$athlete->email}}</a></dd>

                        <dt>Phone:</dt>
                        <dd><a href="tel:+1{{{$athlete->phone}}}">{{$athlete->phone}}</a></dd>

                        <dt>Address:</dt>
                        <dd>
                            <a target="_blank" href="https://www.google.com/maps/search/?api=1&query={{{$athlete->street}}}+{{{$athlete->city}}}+{{{$athlete->state}}}+{{{$athlete->zip}}}">
                                {{$athlete->street}}<br>
                                {{$athlete->city}} {{$athlete->state}}, {{$athlete->zip}}
                            </a>
                        </dd><hr>
                    </dl>


                    <h4>Tryout Info</h4>
                    <dl class="uk-description-list-horizontal">
                        <dt>ID:</dt>
                        <dd>{{$athlete->tryout->id}}</dd>
                        <dt>Start Time:</dt>
                        <dd>{{$athlete->tryout->event_time->toDayDateTimeString()}}</dd>
                        <dt>Location:</dt>
                        <dd>{{$athlete->tryout->location->name}}</dd>
                    </dl><hr>


                    <h4>Emergency Contact Info</h4>
                    <dl class="uk-description-list-horizontal">
                        <dt>Name:</dt>
                        <dd>{{$athlete->emergencyName}}</dd>

                        <dt>Relationship:</dt>
                        <dd>{{$athlete->emergencyRelationship}}</dd>

                        <dt>Phone:</dt>
                        <dd><a href="tel:+1{{{$athlete->emergencyPhone}}}">{{$athlete->emergencyPhone}}</a></dd>
                    </dl><hr>


                    <h4>Notes</h4>
                    <dl class="uk-description-list-horizontal">
                        <dt>Notes:</dt>
                        <dd>{{$athlete->notes}}</dd>
                    </dl><hr>


                    <h4>System Info</h4>
                    <dl class="uk-description-list-horizontal">
                        <dt>Id:</dt>
                        <dd>{{$athlete->id}}</dd>

                        <dt>Signed Up:</dt>
                        <dd>{{$athlete->created_at->toDayDateTimeString()}}</dd>
                    </dl>

                </div>

                <div class="uk-card-body">
                    <h4>You Made The Team Email</h4>
                    <form class="uk-grid-small" uk-grid action="/swim-team/congrats-email" method="POST">
                        {{ csrf_field() }}
                        <div class="uk-margin uk-width-1-1@s">
                            <label class="uk-form-label uk-heading-bullet" for="level_id">Level</label>
                            <div class="uk-form-controls">
                                <select class="uk-select" name="level_id" id="level_id">
                                    @foreach($levels as $level)
                                        <option value="{{$level->id}}">{{$level->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <input type="hidden" name="athlete_id" value="{{{$athlete->id}}}">
                        <p uk-margin>
                            <button class="uk-button uk-button-primary" type="submit"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Send</button>
                        </p>
                    </form>
                </div>

                <div class="uk-card-footer">
                    <a class="uk-button uk-button-primary" href="/athlete/{{{$athlete->id}}}/edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                    <button class="uk-button uk-button-danger" uk-toggle="target: #delete-modal" type="button"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                </div>
            </div>
        </div>
    </div>




    <!-- Modal -->
    <div id="delete-modal" uk-modal="center: true">
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Delete Warning</h2>
            </div>
            <div class="uk-modal-body">
                <p>Are you sure you want to delete {{$athlete->firstName}} {{$athlete->lastName}}?</p>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-primary uk-modal-close" type="button">Cancel</button>
                <form method="POST" action="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE" />
                    <button type="submit" class="uk-button uk-button-danger uk-margin-top">
                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
