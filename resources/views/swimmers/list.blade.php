@extends('layouts.app-uikit')

@section('heading')
Search Swimmers
@endsection

@section('content')
<div class="uk-section-default uk-section-overlap uk-section">
    <div class="uk-container">
        <div id="search" class="uk-margin-top uk-margin-bottom">
            <search :allswimmers="{{json_encode($swimmers)}}"></search>
        </div>
    </div>
</div>
@endsection
