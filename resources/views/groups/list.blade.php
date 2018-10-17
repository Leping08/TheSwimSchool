@extends('layouts.app-uikit')

@section('seo')
    <title>Group Swim Lessons | Parrish Swimming Classes | The Swim School Florida</title>
    <meta name="description" content="Group swim lessons are available for swimmers of all levels! From infants to advanced youth, The Swim School near Parrish Florida is available for everyone. Sign up online today!"/>
@endsection

@section('heading')
    Group Lessons
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">

            <div class="uk-alert-primary" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p>The Swim School offers group swim lessons seasonally March through October.</p>
            </div>

            <div class="uk-grid-margin uk-grid" uk-grid="">
                <div class="uk-width-4-4@m uk-first-column">
                    <h2 class="uk-heading-line"><span>Pricing</span></h2>
                    <div class="uk-child-width-1-2@m uk-grid-small uk-grid-match" uk-grid>
                        <div>
                            <div class="uk-card uk-card-default uk-card-body">
                                <h5>Weekday Session (8 Classes)</h5>
                                <ul class="uk-list uk-list-bullet">
                                    <li>All Levels $85.00</li>
                                </ul>
                            </div>
                        </div>
                        <div>
                            <div class="uk-card uk-card-default uk-card-body">
                                <h5>Weekend Session (6 Classes)</h5>
                                <ul class="uk-list uk-list-bullet">
                                    <li>All Levels $65.00</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="uk-width-1-1@m uk-first-column">
                    <h2 class="uk-heading-line"><span>Location</span></h2>
                    <div class="uk-child-width-1-1@m uk-grid-small uk-grid-match" uk-grid>
                        <div class="uk-card uk-card-default uk-card-body">
                            <iframe height="300" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=5755%20Harrison%20Ranch%20Blvd.%2C%20%20Parrish%2C%20FL%2034219&key=AIzaSyAdLooRUbxGjnlY2k8HDa_zkXYQB4U7s9w&zoom=12" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>


                <div class="uk-grid-margin uk-grid" uk-grid="">
                    <div class="uk-width-4-4@m uk-first-column">
                        @if(count($groups))
                            <h2 class="uk-heading-line"><span>Levels</span></h2>
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
                                            <a title="Manatee County Swimming Classes" href="/lessons/{{{$group->type}}}" class="uk-button uk-button-primary">Find Classes</a>
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
                </div>
            </div>
        </div>
        <style>
            @media (max-width: 960px) {
                .uk-card-badge {
                    position: inherit;
                    top: 5px;
                }
            }
            @media (min-width: 960px) {
                .uk-label {
                    font-size: 12px;
                    padding: 5px 16px !important;
                }
            }
        </style>
    </div>
@endsection
