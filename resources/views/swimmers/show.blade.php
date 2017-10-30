@extends('layouts.app-uikit')

@section('heading')
{{$swimmer->name}}
@endsection

@section('content')
<div class="uk-section-default uk-section-overlap uk-section">
    <div class="uk-container">
        <div class="uk-card uk-card-default uk-width-1-1@s">
            <div class="uk-card-body">
                <h4>Swimmer Info</h4>
                <dl class="uk-description-list-horizontal">
                    <dt>Name:</dt>
                    <dd>{{$swimmer->name}}</dd>

                    <dt>Age:</dt>
                    <dd>{{$swimmer->age}}</dd>

                    <dt>Email:</dt>
                    <dd><a href="mailto:{{{$swimmer->email}}}">{{$swimmer->email}}</a></dd>

                    <dt>Phone:</dt>
                    <dd><a href="tel:+1{{{$swimmer->phone}}}">{{$swimmer->phone}}</a></dd>

                    <dt>Address:</dt>
                    <dd>
                        <a target="_blank" href="https://www.google.com/maps/search/?api=1&query={{{$swimmer->street}}}+{{{$swimmer->city}}}+{{{$swimmer->state}}}+{{{$swimmer->zip}}}">
                            {{$swimmer->street}}<br>
                            {{$swimmer->city}} {{$swimmer->state}}, {{$swimmer->zip}} 
                        </a>
                    </dd><hr>



                    <h4>Lesson Info</h4>
                    <dl class="uk-description-list-horizontal">
                        <dt>Group:</dt>
                        <dd><a href="/lesson/{{$swimmer->lesson->group->id}}">{{$swimmer->lesson->group->type}}</a></dd>
                        <dt>Ages:</dt>
                        <dd>{{$swimmer->lesson->group->ages}}</dd>
                        <dt>Location:</dt>
                        <!-- TODO: make linkable -->
                        <dd>{{$swimmer->lesson->location->name}}</dd>
                        <dt>Season:</dt>
                        <!-- TODO: make linkable -->
                        <dd>{{$swimmer->lesson->season->season}} {{$swimmer->lesson->season->year}}</dd>
                    </dl><hr>


                <h4>Payment Info</h4>
                @if($swimmer->paid == 1)
                <dl class="uk-description-list-horizontal">
                    <dt>Payment:</dt>
                    <dd><span class="badge badge-default badge-success">Online</span></dd>

                    <dt>Price</dt>
                    <dd>${{$swimmer->lesson->price}}</dd>

                    <dt>Stripe Charge Id:</dt>
                    <dd>{{$swimmer->stripechargeid}}</dd>
                </dl><hr>
                @elseif($swimmer->paid == 0)
                <dl class="uk-description-list-horizontal">
                    <dt>Payment:</dt>
                    <dd><span class="badge badge-default badge-primary">Cash/Check</span></dd>
                    <dt>Price</dt>
                    <dd>${{$swimmer->lesson->price}}</dd>
                </dl><hr>
                @endif


                <h4>Emergency Contact Info</h4>
                <dl class="uk-description-list-horizontal">
                    <dt>Name:</dt>
                    <dd>{{$swimmer->emergencyName}}</dd>

                    <dt>Relationship:</dt>
                    <dd>{{$swimmer->emergencyRelationship}}</dd>

                    <dt>Phone:</dt>
                    <dd><a href="tel:+1{{{$swimmer->emergencyPhone}}}">{{$swimmer->emergencyPhone}}</a></dd>
                </dl><hr>


                <h4>Notes</h4>
                <dl class="uk-description-list-horizontal">
                    <dt>Notes:</dt>
                    <dd>{{$swimmer->notes}}</dd>
                </dl><hr>


                <h4>System Info</h4>
                <dl class="uk-description-list-horizontal">
                    <dt>Id:</dt>
                    <dd>{{$swimmer->id}}</dd>

                    <dt>Signed Up:</dt>
                    <dd>{{$swimmer->created_at->toDayDateTimeString()}}</dd>
                </dl>

            </div>
            <div class="uk-card-footer">
                <a class="uk-button uk-button-primary" href="/swimmers/{{{$swimmer->id}}}/edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
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
            <p>Are you sure you want to delete {{$swimmer->name}}?</p>
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
