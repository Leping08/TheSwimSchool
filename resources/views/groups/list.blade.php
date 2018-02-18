@extends('layouts.app-uikit')

@section('heading')
    Group Lessons
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            @if(count($groups))
                @foreach($groups as $group)
                    <div class="uk-margin-top">
                        <div class="uk-card uk-card-default uk-width-1-1@s" uk-scrollspy="cls: uk-animation-slide-bottom; delay: 250">
                            <div class="uk-card-header">
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-expand">
                                        <h3 class="uk-card-title f-24 uk-heading-bullet">{{$group->type}}</h3>
                                        <div class="uk-card-badge uk-label">{{$group->ages}}</div>
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
            @else
                <div class="uk-card-body">
                    No groups available.
                </div>
            @endif
        </div>
        <style>
            @media (max-width: 640px) {
                .uk-card-badge {
                    position: inherit;
                    top: 5px;
                }
            }
        </style>
    </div>
@endsection
