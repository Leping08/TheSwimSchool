@extends('layouts.app-uikit')

@section('seo')
    <title>The {{ config('swim-team.full-name') }} Tryouts Form | The Swim School Parrish FL</title>
    <meta name="description" content="Are you interested in joining The {{ config('swim-team.full-name') }}? Sign up for tryouts by visiting The Swim School's website or calling 941-773-1424."/>
@endsection

@section('heading')
    {{ config('swim-team.name') }} Tryouts
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-flex-middle uk-grid-margin uk-grid" uk-grid="">
                <div class="uk-width-expand@m uk-first-column">
                    @if($tryouts->count())
                        @foreach($tryouts as $tryout)
                            <div class="uk-card uk-card-default uk-margin-top">
                                <div class="uk-card-header">
                                    <div class="uk-card-title f-24 uk-heading-bullet">{{$tryout->event_time->format('l F jS')}}</div>
                                </div>
                                <div class="uk-card-body">
                                    <div class="card-text">
                                        <div class="uk-child-width-expand@s" uk-grid>
                                            <!--<div><i class="fa fa-users fa-lg" aria-hidden="true"></i> <strong>Tryout Size:</strong> {{$tryout->class_size}}</div>-->
                                            <div><i class="fa fa-user fa-lg" aria-hidden="true"></i> <strong>Spots Remaining:</strong> {{$tryout->class_size - $tryout->athletes->count()}}</div>
                                            <div><i class="fa fa-clock-o fa-lg" aria-hidden="true"></i> <strong>Time:</strong> {{$tryout->event_time->format('g:i a')}} - {{$tryout->event_time->addHour()->addMinutes(30)->format('g:i a')}}</div>
                                            <div><i class="fa fa-map-marker fa-lg" aria-hidden="true"></i> <strong>Location:</strong> {{$tryout->location->name}}<br><a title="Swim Lessons Bradenton" target="_blank" href="https://www.google.com/maps/search/?api=1&query={{{$tryout->location->street}}}+{{{$tryout->location->city}}}+{{{$tryout->location->state}}}+{{{$tryout->location->zip}}}">{{$tryout->location->street}}, <br>{{$tryout->location->city}}, {{$tryout->location->state}} {{$tryout->location->zip}}</a></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-card-footer">
                                    @if($tryout->isFull())
                                        <button class="uk-button uk-button-primary" disabled>Tryout Full</button>
                                    @else
                                        <a title="{{ config('swim-team.full-name') }}" href="{{ route('swim-team.tryouts.show', [$tryout]) }}" class="uk-button uk-button-primary">Sign Up</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-header">
                                <h3 class="uk-heading-bullet">Sorry No Tryouts Available At This Time</h3>
                            </div>
                            <div class="uk-card-body">
                                <div class="card-text">
                                    <p>In the mean time check out our <a title="Bradenton Group Swimming Lessons" href="{{ route('groups.lessons.index') }}">group swim lessons</a>.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

