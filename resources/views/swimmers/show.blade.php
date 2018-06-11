@extends('layouts.app-uikit')

@section('heading')
{{$swimmer->firstName}} {{$swimmer->lastName}}
@endsection

@section('content')
<div class="uk-section-default uk-section-overlap uk-section">
    <div class="uk-container">
        <div class="uk-card uk-card-default uk-width-1-1@s">
            <div class="uk-card-body">
                <h4>Swimmer Info</h4>
                <dl class="uk-description-list-horizontal">
                    <dt>Name:</dt>
                    <dd>{{$swimmer->firstName}} {{$swimmer->lastName}}</dd>

                    <dt>Birth Date:</dt>
                    <dd>{{$swimmer->birthDate->toDateString()}}</dd>

                    <dt>Age:</dt>
                    @if($swimmer->yearsOld() < 2)
                        <dd>{{$swimmer->monthsOld()}} months old</dd>
                    @else
                        <dd>{{$swimmer->yearsOld()}} years old</dd>
                    @endif
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
                </dl>



                <h4>Lesson Info</h4>
                <dl class="uk-description-list-horizontal">
                    <dt>Id:</dt>
                    <dd>{{$swimmer->lesson->id}}</dd>
                    <dt>Group:</dt>
                    <dd><a href="/lesson/{{$swimmer->lesson->id}}">{{$swimmer->lesson->group->type}}</a></dd>
                    <dt>Ages:</dt>
                    <dd>{{$swimmer->lesson->group->ages}}</dd>
                    <dt>Location:</dt>
                    <dd><a href="/locations/{{$swimmer->lesson->location->id}}">{{$swimmer->lesson->location->name}}</a></dd>
                    <dt>Season:</dt>
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
                    <dd>{{$swimmer->stripeChargeId}}</dd>
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
            <p>Are you sure you want to delete {{$swimmer->firstName}} {{$swimmer->lastName}}?</p>
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
