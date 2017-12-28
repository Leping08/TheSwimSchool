@extends('layouts.app-uikit')

@section('heading')
    {{$lesson[0]->group->type}}
@endsection

@section('content')

    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-card uk-card-default uk-width-1-1@s">
                @if(count($lesson))
                    <div class="uk-card-body">
                        <h4>Lesson Info</h4>
                        <dl class="uk-description-list-horizontal">
                            <dt>Id:</dt>
                            <dd>{{$lesson[0]->id}}</dd>

                            <dt>Price:</dt>
                            <dd>${{$lesson[0]->price}}</dd>

                            <dt>Class Size:</dt>
                            <dd>{{$lesson[0]->class_size}}</dd>

                            <dt>Open Spots:</dt>
                            <dd>{{$lesson[0]->class_size - count($lesson[0]->swimmers)}}</dd>

                            <dt>Registration Open:</dt>
                            <dd>{{$lesson[0]->registration_open->format('m/d/Y')}}</dd>

                            <dt>Class Length:</dt>
                            <dd>{{$lesson[0]->class_start_date->format('m/d/Y')}} - {{$lesson[0]->class_end_date->format('m/d/Y')}}</dd>

                            <dt>Class Time:</dt>
                            <dd>
                                @foreach($days as $day)
                                    {{$day->day}}: {{$lesson[0]->class_start_time->format('g:i a')}} - {{$lesson[0]->class_end_time->format('g:i a')}}<br>
                                @endforeach
                            </dd>
                        </dl><hr>

                        <h4>Group</h4>
                        <dl class="uk-description-list-horizontal">
                            <dt>Type:</dt>
                            <dd>{{$lesson[0]->group->type}}</dd>

                            <dt>Ages:</dt>
                            <dd>{{$lesson[0]->group->ages}}</dd>

                            <dt>Location:</dt>
                            <dd>{{$lesson[0]->location->name}}</dd>

                            <dt>Season:</dt>
                            <dd>{{$lesson[0]->season->season}} {{$lesson[0]->season->year}}</dd>
                        </dl>

                        <h4>Swimmers</h4>
                        <ul class="uk-list uk-list-striped">
                            @foreach($lesson[0]->swimmers as $swimmer)
                                <li><a href="/swimmers/{{{$swimmer->id}}}" class="list-group-item list-group-item-action justify-content-between">
                                        @if($swimmer->paid == 1)
                                            {{$swimmer->name}}
                                        @elseif($swimmer->paid == 0)
                                            {{$swimmer->name}}
                                        @endif
                                    </a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="uk-card-footer">
                        <a class="uk-button uk-button-default" disabled><i class="fa fa-pencil" aria-hidden="true"></i> Edit Coming Soon</a>
                        <!-- TODO: Edit a lesson button -->
                        <!-- <a class="uk-button uk-button-primary" href="/lessons/{{{$lesson[0]->id}}}/edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a> -->
                        <button class="uk-button uk-button-danger" uk-toggle="target: #delete-modal" type="button"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                    </div>
                @else
                    <div class="uk-card-body">
                        We cant find that lesson.
                    </div>
                @endif
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
                <p>Are you sure you want to delete {{$lesson[0]->id}}?</p>
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

