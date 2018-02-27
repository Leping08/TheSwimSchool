@extends('layouts.app-uikit')

@section('heading')
Lessons
@endsection

@section('content')
    <!-- If active lessons exist display them -->
    @if(count($group->OpenSignUps))
        <div class="uk-section-default uk-section-overlap uk-section">
            <div class="uk-container ">
                @foreach($group->OpenSignUps as $lesson)
                <div class="uk-card uk-card-default uk-margin-top">
                    <div class="uk-card-header">
                        <div class="uk-card-title f-24 uk-heading-bullet">{{$group->type}}</div>
                    </div>
                    <div class="uk-card-body">
                        <div class="uk-child-width-expand@s" uk-grid>
                            <div><i class="fa fa-users fa-lg" aria-hidden="true"></i> <strong>Class Size:</strong> {{$lesson->class_size}}</div>
                            <div><i class="fa fa-money fa-lg" aria-hidden="true"></i> <strong>Price:</strong> ${{$lesson->price}}</div>
                            <div><i class="fa fa-calendar fa-lg" aria-hidden="true"></i> <strong>Dates:</strong> {{$lesson->class_start_date->toFormattedDateString()}} - {{$lesson->class_end_date->toFormattedDateString()}}</div>
                        </div>

                        <div class="uk-child-width-expand@s" uk-grid>
                            <div><i class="fa fa-user fa-lg" aria-hidden="true"></i> <strong>Spots Remaining:</strong> {{$lesson->class_size - $lesson->Swimmers->count()}}</div>
                            <div><i class="fa fa-map-marker fa-lg" aria-hidden="true"></i> <strong>Location:</strong> {{$lesson->location->name}}<br><a target="_blank" href="https://www.google.com/maps/search/?api=1&query={{{$lesson->location->street}}}+{{{$lesson->location->city}}}+{{{$lesson->location->state}}}+{{{$lesson->location->zip}}}">{{$lesson->location->street}}, <br>{{$lesson->location->city}}, {{$lesson->location->state}} {{$lesson->location->zip}}</a></div>
                            <div><i class="fa fa-clock-o fa-lg" aria-hidden="true"></i> <strong>Times:</strong><br>
                                @foreach($lesson->DaysOfTheWeek as $day)
                                    {{$day->day}} {{$lesson->class_start_time->format('g:i a')}} - {{$lesson->class_end_time->format('g:i a')}}<br>
                                @endforeach
                            </div>
                        </div>

                        @if (Auth::guest())

                        @else
                            <ul class="uk-list uk-list-striped">
                                <li><strong>Swimmers</strong></li>
                                @foreach($lesson->Swimmers as $swimmer)
                                    <li><a href="/swimmers/{{{$swimmer->id}}}" class="list-group-item list-group-item-action justify-content-between">
                                        {{$swimmer->firstName}} {{$swimmer->lastName}}
                                    </a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="uk-card-footer">
                        @if($lesson->class_size - $lesson->Swimmers->count() > 0)
                            <a href="/lessons/{{{$group->type}}}/{{{$lesson->id}}}" class="uk-button uk-button-primary">Sign Up</a>
                        @else
                            <button class="uk-button uk-button-primary" disabled>Class Full</button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    <!-- No active lessons exist so display no classes -->
    @else
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
    @endif
@endsection

