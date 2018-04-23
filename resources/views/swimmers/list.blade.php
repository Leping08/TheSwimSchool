@extends('layouts.app-uikit')

@section('heading')
Search Swimmers
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            @if(count($swimmers))
                <div class="uk-margin-top uk-margin-bottom">
                    <search :allswimmers="{{json_encode($swimmers)}}"></search>
                </div>
            @else
                <ul class="uk-list uk-list-striped">
                    <li><b>Swimmers</b></li>
                    <li>
                        No Swimmers are signed up.
                    </li>
                </ul>
            @endif
        </div>
    </div>
@endsection
