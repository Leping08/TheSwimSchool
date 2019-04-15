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
            @if(config('season.groups.off-season'))
                <div class="uk-alert-primary" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p>{{--Next weekend group lesson registration opens {{config('season.groups.next_season.registration_open')}}.--}} Next weekday group lesson registration opens April 22nd. For the full schedule, check out the <a href="/lessons/schedule">2019 group lesson schedule</a>.</p>
                </div>
            @endif

            <div class="uk-width-1-1@m uk-first-column uk-margin-top">
                <h2 class="uk-heading-line"><span>Location</span></h2>
                <div class="uk-card uk-card-default">
                    <iframe height="300" class="uk-width-1-1" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=5755%20Harrison%20Ranch%20Blvd.%2C%20%20Parrish%2C%20FL%2034219&key={{config('google.maps.api_key')}}&zoom=12" allowfullscreen></iframe>
                </div>
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
                                    <li>Swim Club Levels (Flying Fish & Shark) $100</li>
                                </ul>
                            </div>
                        </div>
                        <div>
                            <div class="uk-card uk-card-default uk-card-body">
                                <h5>Weekend Session (6 Classes)</h5>
                                <ul class="uk-list uk-list-bullet">
                                    <li>All Levels $65.00</li>
                                    <li>Swim Club Levels Offered Weekday Sessions Only</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="uk-width-1-1@m uk-first-column uk-margin-top">
                <h2 class="uk-heading-line"><span>Levels</span></h2>
                <div class="uk-grid-small uk-grid-match uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@lg" uk-grid>
                    @forelse($groups as $group)
                        <div class="">
                            <div class="uk-margin uk-text-center uk-card uk-card-default uk-card-body uk-scrollspy-inview uk-animation-fade" uk-scrollspy-class="uk-animation-fade">
                                <img class="uk-width-1-2" alt="" src="{{$group->iconPath}}">
                                <h2 class="uk-margin uk-h3">{{$group->type}}</h2>
                                <p class="uk-text-meta uk-text-primary">{{$group->ages}}</p>
                                <div class="uk-margin">{{str_limit($group->description, 350)}}</div>
                                <p><a class="uk-button uk-button-primary" href="/lessons/{{{$group->type}}}">Find Classes</a></p>
                            </div>
                        </div>
                    @empty
                        <div class="">
                            <div class="uk-margin uk-text-center uk-card uk-card-default uk-card-body">
                                <h2 class="uk-margin uk-h3">No levels available at this time.</h2>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
