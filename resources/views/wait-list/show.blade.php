@extends('layouts.app-uikit')

@section('heading')
    {{$waitingSwimmer->name}}
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-card uk-card-default uk-width-1-1@s">
                <div class="uk-card-body">
                    <h4>Swimmer on Wait List</h4>
                    <dl class="uk-description-list-horizontal">
                        <dt>ID:</dt>
                        <dd>{{$waitingSwimmer->id}}</dd>

                        <dt>Name:</dt>
                        <dd>{{$waitingSwimmer->name}}</dd>

                        <dt>Email:</dt>
                        <dd>{{$waitingSwimmer->email}}</dd>

                        <dt>Phone:</dt>
                        <dd>{{$waitingSwimmer->phone}}</dd>
                    </dl>

                    <h4>Lesson</h4>
                    <dl class="uk-description-list-horizontal">
                        <dt>ID:</dt>
                        <dd>{{$waitingSwimmer->lesson->id}}</dd>
                        <dt>Name:</dt>
                        <dd><a href="/lesson/{{$waitingSwimmer->lesson->id}}">{{$waitingSwimmer->lesson->group->type}}</a></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
