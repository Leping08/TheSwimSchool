@extends('layouts.app-uikit')

@section('heading')
    Groups
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        @if(Auth::check())
            <div class="uk-container">
                <a class="uk-button uk-button-primary uk-align-right uk-icon" uk-icon="icon: plus" href=""></a>
            </div>
        @endif
        <div class="uk-container">
            @foreach($groups as $group)
                <div class="uk-margin-top">
                    <div class="uk-card uk-card-default uk-width-1-1@s" uk-scrollspy="cls: uk-animation-slide-bottom; delay: 250">
                        <div class="uk-card-header">
                            <div class="uk-grid-small uk-flex-middle" uk-grid>
                                <div class="uk-width-expand">
                                    <div class="uk-card-badge uk-label">{{$group->ages}}</div>
                                    <h3 class="uk-card-title f-24 uk-heading-bullet">{{$group->type}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="uk-card-body">
                            <p>{{$group->description}}</p>
                        </div>
                        <div class="uk-card-footer">
                            <a href="/lessons/{{{$group->type}}}" class="uk-button uk-button-primary">Find Classes</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
