@extends('layouts.app-uikit')

@section('heading')
    {{$lesson->group->type}}
@endsection

@section('content')

    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-card uk-card-default uk-width-1-1@s">
                @if($lesson)
                    <div class="uk-card-body">
                        <h4>Lesson Info</h4>
                        <dl class="uk-description-list-horizontal">
                            <dt>Id:</dt>
                            <dd>{{$lesson->id}}</dd>

                            <dt>Price:</dt>
                            <dd>${{$lesson->price}}</dd>

                            <dt>Class Size:</dt>
                            <dd>{{$lesson->class_size}}</dd>

                            <dt>Open Spots:</dt>
                            <dd>{{$lesson->class_size - count($lesson->swimmers)}}</dd>

                            <dt>Registration Open:</dt>
                            <dd>{{$lesson->registration_open->format('m/d/Y')}}</dd>

                            <dt>Class Length:</dt>
                            <dd>{{$lesson->class_start_date->format('m/d/Y')}} - {{$lesson->class_end_date->format('m/d/Y')}}</dd>

                            <dt>Class Time:</dt>
                            <dd>
                                @foreach($lesson->DaysOfTheWeek as $day)
                                    {{$day->day}}: {{$lesson->class_start_time->format('g:i a')}} - {{$lesson->class_end_time->format('g:i a')}}<br>
                                @endforeach
                            </dd>
                        </dl><hr>

                        <h4>Group</h4>
                        <dl class="uk-description-list-horizontal">
                            <dt>Type:</dt>
                            <dd>{{$lesson->group->type}}</dd>

                            <dt>Ages:</dt>
                            <dd>{{$lesson->group->ages}}</dd>

                            <dt>Location:</dt>
                            <dd>{{$lesson->location->name}}</dd>

                            <dt>Season:</dt>
                            <dd>{{$lesson->season->season}} {{$lesson->season->year}}</dd>
                        </dl>
                        <hr>

                        <h4>Email Lesson Link</h4>
                        <div>
                            <form class="uk-grid-small" uk-grid action="/lesson-link-email/{{{$lesson->id}}}" method="POST">
                                {{ csrf_field() }}
                                <div class="uk-width-1-1@s">
                                    <input type="email" class="uk-input" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                                </div>
                                <div class="">
                                    <button type="submit" class="uk-button uk-button-primary">Send Email</button>
                                </div>
                            </form>
                        </div>
                        <hr>

                        <h4>Swimmers</h4>
                        <ul class="uk-list uk-list-striped">
                            @if($lesson->swimmers->count())
                            @foreach($lesson->swimmers as $swimmer)
                                <li>
                                    <a href="/swimmers/{{{$swimmer->id}}}" class="list-group-item list-group-item-action justify-content-between">
                                        {{$swimmer->firstName}} {{$swimmer->lastName}}
                                    </a>
                                </li>
                            @endforeach
                            @else
                                No Swimmers
                            @endif
                        </ul>

                        <hr>
                        <h4>Wait List</h4>
                        {{--TODO: Add a way to send email to people in wait list about the lesson having an open spot.--}}
                        {{--TODO: Make sure you can not sign up for the wait list for a private lesson.--}}
                        <ul class="uk-list uk-list-striped">
                            @if($lesson->WaitList->count())
                                @foreach($lesson->WaitList as $waitingSwimmers)
                                    <li>
                                        <a href="/wait-list/{{{$waitingSwimmers->id}}}" class="list-group-item list-group-item-action justify-content-between">
                                            {{$waitingSwimmers->name}}
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                No one on the wait list
                            @endif
                        </ul>
                    </div>
                    <div class="uk-card-footer" uk-margin>
                        <a href="/lessons/{{{$lesson->group->type}}}/{{{$lesson->id}}}" class="uk-button uk-button-primary" target="_blank"><i class="fa fa-link" aria-hidden="true"></i> Sign Up Link</a>
                        <a class="uk-button uk-button-primary" href="/lesson/{{{$lesson->id}}}/edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
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
                <p>Are you sure you want to delete Lesson ID: {{$lesson->id}}? Make sure this lesson has no swimmers in it.</p>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-primary uk-modal-close" type="button">Cancel</button>
                <form method="POST" action="/lesson/{{{$lesson->id}}}">
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

