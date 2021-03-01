@extends('layouts.app-uikit')

@section('seo')
    <title>The {{ config('swim-team.name') }} | Parrish Swimming | The Swim School Florida</title>
    <meta name="description" content="The Swim School near Parrish Florida invites you to come join our team! The {{ config('swim-team.name') }} is holding tryouts at the River Wildnerness Country Club. Sign up for tryouts today."/>
@endsection

@section('heading')
    {{ config('swim-team.name') }}
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section uk-section-small">
        <div class="uk-container">
            @if($banner && $banner->active)
                <div class="uk-alert-primary" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    {!! $banner->text !!}
                </div>
            @endif
            <div class="uk-grid-margin uk-grid" uk-grid="">
                <div class="uk-grid-item-match uk-flex-middle uk-width-3-4@m uk-first-column">
                    <div class="uk-panel">
                        <h2 class="uk-heading-line"><span>2021 {{ config('swim-team.name') }} Swim Team</span></h2>
                        <div class="uk-dropcap uk-margin">
                            <p>
                                Registration is now open for our 2021 pre-season Swim Club. For more information and to register, check out our <a href="/lessons/Flying%20Fish%20Level%20(Youth%20Advanced%20-%20Swim%20Club)">Flying Fish Swim Club</a> for 6-8 year olds
                                and our <a href="/lessons/Shark%20Level%20(Youth%20Advanced%20-%20Swim%20Club)">Shark Swim Club</a> for ages 9 years & up. Information regarding our 2021 Summer Swim Team tryouts and season will be available by April 15th.
                                Stay up to date with everything we are doing on our <a href="https://www.facebook.com/North-River-Rapids-Swim-Team-209249439805502/" target="_blank">Facebook page</a>.
                            </p>
{{--                            <p>--}}
{{--                                Bring your suit, goggles & towel and come join our team! The {{ config('swim-team.full-name') }} competes in a seasonal, developmental swim league.--}}
{{--                                The summer season runs <strong>Monday, June 1st- Sunday, August 2nd</strong> and practices are held at the River Wilderness Golf & Country Club pool.--}}
{{--                                Registration is now open for our 2020 pre-season Swim Club. For more information and to register, check out our <a href="/lessons/Flying%20Fish%20Level%20(Youth%20Advanced%20-%20Swim%20Club)">Flying Fish Swim Club</a> for 6-8 year olds and our <a href="/lessons/Shark%20Level%20(Youth%20Advanced%20-%20Swim%20Club)">Shark Swim Club</a> for ages 9 years & up.--}}
{{--                                Stay up to date with everything we are doing on our <a href="https://www.facebook.com/North-River-Rapids-Swim-Team-209249439805502/" target="_blank">Facebook page</a>.--}}
{{--                            </p>--}}
                        </div>
                        {{--<div class="uk-margin">
                            <div class="uk-child-width-auto uk-grid-small uk-grid uk-grid-stack" uk-grid="">
                                <div class="uk-first-column">
                                    <a class="el-link uk-icon-button uk-icon" href="https://www.facebook.com/North-River-Rapids-Swim-Team-209249439805502/" target="_blankß" uk-icon="icon: facebook;">
                                        <svg width="20" height="20" viewBox="0 0 20 20"
                                             xmlns="http://www.w3.org/2000/svg" data-svg="facebook">
                                            <path d="M11,10h2.6l0.4-3H11V5.3c0-0.9,0.2-1.5,1.5-1.5H14V1.1c-0.3,0-1-0.1-2.1-0.1C9.6,1,8,2.4,8,5v2H5.5v3H8v8h3V10z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>--}}
{{--                        <div>--}}
{{--                            <h2 class="uk-heading-line"><span>Tryouts</span></h2>--}}
{{--                            <p>--}}
{{--                                Registration for swim team tryouts opens on May 1st. There is no fee to tryout for the swim team. Tryouts are held at the River Wilderness Golf & Country Club pool.--}}
{{--                                <strong>All interested participants must sign up for and attend one of the team tryouts. There is no fee to tryout for the swim club.</strong>--}}
{{--                            </p>--}}
{{--                            <ul class="uk-list uk-list-bullet">--}}
{{--                                <li>Tuesday, May 19th at 6:30PM</li>--}}
{{--                                <li>Wednesday, May 20th at 6:30PM</li>--}}
{{--                                <li>Saturday, May 23rd at 1:00PM</li>--}}
{{--                            </ul>--}}
{{--                            <p>--}}
{{--                                *Minimum Requirement: Each child must be able to swim at least one full individual length without stopping (25 meters) of each of the four competitive swim strokes (freestyle, backstroke, breaststroke, and butterfly) to be eligible for participation on the team. Each stroke will be demonstrated at the tryout prior to having the children attempt them.--}}
{{--                            </p>--}}
{{--                            <p>--}}
{{--                                Need some practice first? We have <a href="{{ route('groups.lessons.index') }}">group</a> and--}}
{{--                                <a href="{{ route('private_lesson.index') }}">private swim lesson</a> options available now to get your child ready for their tryout.--}}
{{--                            </p>--}}
{{--                        </div>--}}
                        {{--<div>
                            <h2 class="uk-heading-line"><span>2019 Fall Swim Team Season</span></h2>
                            <p>The {{ config('swim-team.name') }} practices at the <a title="{{ config('swim-team.full-name') }}" target="_blank" href="http://www.riverwildernesscc.com/">River Wilderness Country Club</a> and competes in the Suncoast Swim League, a seasonal developmental league that runs September 5th - October 31st.</p>
                            <p>Season Runs Tuesday, September 3rd - Wednesday, October 30th and is held at the River Wilderness Golf & Country Club pool.</p>
                        </div>--}}
                        {{-- <div>
                            <!-- TODO: Add tryout that lasts all season -->
                            <a class="uk-button uk-button-primary" href="{{ route('swim-team.tryouts.index') }}">Sign Up for Tryouts</a>
                            <a class="uk-button uk-button-default" disabled>Registration Coming Soon</a>
                        </div>--}}
                    </div>
                </div>
                <div class="uk-grid-item-match uk-flex-middle uk-width-expand@m">
                    <div class="uk-panel">
                        <div class="uk-margin">
                            {{--<img class="" alt="" src="/img/logos/north-river-rapids.png">--}}
{{--                            <img class="" alt="" src="{{ asset('/img/swim-team/dive-cropped.jpg') }}">--}}
                            <img class="uk-border-rounded uk-box-shadow-large" alt="" src="{{ asset('/img/thank-you/breast-stroke.jpg') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


{{--    <div class="uk-section-default uk-section-overlap uk-section uk-section-small">--}}
{{--        <div class="uk-container">--}}
{{--            <div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid="">--}}
{{--                <div class="uk-width-1-1@m uk-first-column">--}}
{{--                    <h2 class="uk-heading-line">--}}
{{--                        <span>Groups &amp; Practice Schedules</span>--}}
{{--                    </h2>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="uk-grid-margin uk-grid" uk-grid="">--}}
{{--                <div class="uk-width-expand@m uk-first-column">--}}
{{--                    <div class="uk-margin">--}}
{{--                        <img class="uk-border-rounded uk-box-shadow-large" alt="" src="{{ asset('/img/swim-team/2018-class.jpg') }}">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="uk-grid-item-match uk-flex-middle uk-width-2-3@m">--}}
{{--                    <div class="uk-panel">--}}
{{--                        <div class="uk-margin">Swim team tryout will determine group placement.</div>--}}
{{--                        <ul class="uk-list uk-list-bullet">--}}
{{--                            <li><b>White Team 1:</b> Mon/Wed/Fri 5PM-5:45PM</li>--}}
{{--                            <li><b>White Team 2:</b> Tues/Thurs/Fri 5PM-5:45PM</li>--}}
{{--                            <li><b>Gray Team:</b> Mon/Wed/Fri 5:45PM-6:45PM</li>--}}
{{--                            <li><b>Blue Team:</b> Mon/Wed 6:45PM-7:45PM, Tues/Thurs 5:45PM-7:15PM</li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}


{{--    <div class="uk-section-default uk-section-overlap uk-section uk-section-small">--}}
{{--        <div class="uk-container">--}}
{{--            <div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid="">--}}
{{--                <div class="uk-width-1-1@m uk-first-column">--}}
{{--                    <h2 class="uk-heading-line">--}}
{{--                        <span>Season Pricing</span>--}}
{{--                    </h2>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="uk-grid-margin uk-grid" uk-grid="">--}}
{{--                <div class="uk-grid-item-match uk-flex-middle uk-width-2-3@m uk-first-column">--}}
{{--                    <div class="uk-panel">--}}
{{--                        <div class="uk-margin">No Registration Fees! 10% Discount for River Wilderness Country Club Members (Must provide ID number for verification). 10% Multiple Child Discount. Each child will receive one free team swim cap and team t-shirt. Price also includes swim meet entry fees for the entire season with the exception of the Suncoast Swim League championship meet which has a separate fee collected prior to the meet.</div>--}}
{{--                        <ul class="uk-list uk-list-bullet">--}}
{{--                            <li><b>White Team:</b> $250</li>--}}
{{--                            <li><b>Gray Team:</b> $290</li>--}}
{{--                            <li><b>Blue Team:</b> $330</li>--}}
{{--                        </ul>--}}
{{--                        <div class="uk-margin">*Parent Non-Volunteer Fee per swimmer per season (optional): $50</div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="uk-grid-item-match uk-flex-middle uk-width-expand@m">--}}
{{--                    <div class="uk-panel">--}}
{{--                        <div class="uk-margin">--}}
{{--                            <img class="uk-border-rounded uk-box-shadow-large" alt="" src="{{ asset('/img/thank-you/breast-stroke.jpg') }}">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}


    {{--<div class="uk-section-default uk-section-overlap uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-width-1-1@m uk-margin-top">
                <h2 class="uk-heading-line"><span>Swim Meet Schedule</span></h2>
                <div class="uk-child-width-expand@s" uk-grid>
                    <div class="uk-width-expand@m uk-first-column">
                        <div class="uk-margin">
                            <img class="uk-border-rounded uk-box-shadow-large" alt="" src="{{ asset('/img/swim-team/dive-cropped.jpg') }}">
                        </div>
                    </div>
                    <div class="uk-grid-item-match uk-flex-middle uk-width-2-3@m">
                        <div>
                            <div class="uk-margin">Download the 2019 swim meet schedule. All swim meets are optional but participation is highly encouraged. All swim practices will be cancelled on days when a swim meet occurs</div>
                            <a title="Lakewood Ranch Swim Team" class="uk-button uk-button-primary" href="pdf/NRST_2019_Fall_Swim_Meet_Schedule.pdf" download="NRST_2019_Fall_Swim_Meet_Schedule.pdf">Download</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}


    <div class="uk-section-default uk-section-overlap uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-width-1-1@m">
                <h2 class="uk-heading-line"><span>Coaches</span></h2>
                <div class="uk-margin">
                    <ul uk-tab="connect: #js-350;animation: uk-animation-fade" class="uk-margin el-nav uk-tab">
                        @forelse($coaches as $coach)
                            <li aria-expanded="true" class="uk-active">
                                <a href="#">{{$coach->name}}</a>
                            </li>
                        @empty
                            <li aria-expanded="true" class="uk-active">
                                <a href="#">No Coaches</a>
                            </li>
                        @endforelse
                    </ul>

                    <ul id="js-350" class="uk-switcher" uk-height-match="row: false">
                        @forelse($coaches as $coach)
                            <li class="el-item">
                                <h3 class="el-title uk-margin uk-heading-bullet">{{$coach->name}}</h3>
                                <div class="el-content uk-margin">
                                    <p>{{$coach->bio}}</p>
                                    <a title="Contact {{$coach->name}}" class="uk-button uk-button-default" href="tel:+1{{$coach->phone}}"><span uk-icon="icon: receiver;" class="uk-margin-small-right"></span> {{$coach->phone}}</a>
                                </div>
                            </li>
                        @empty

                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div class="uk-section-default uk-section-overlap uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-width-1-1@m">
                <h2 class="uk-heading-line"><span>Location</span></h2>
                <div class="uk-card uk-card-default">
                    <iframe height="300" class="uk-width-1-1" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=2250%20Wilderness%20Blvd.%20West%20Parrish%20FL%2C%2034219&key={{config('google.maps.api_key')}}&zoom=12" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>


    <div class="uk-section-default uk-section-overlap uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-width-1-1@m uk-margin-top">
                <h2 class="uk-heading-line"><span>Record Holders</span></h2>
                <div class="uk-grid-margin uk-grid" uk-grid="">
                    <div class="uk-width-expand@m uk-first-column">
                        <div class="uk-margin">
                            <img class="uk-border-rounded uk-box-shadow-large" alt="" src="{{ asset('/img/thank-you/winner.jpg') }}">
                        </div>
                    </div>
                    <div class="uk-grid-item-match uk-flex-middle uk-width-2-3@m">
                        <div>
                            <div class="uk-margin">Check out the current {{ config('swim-team.name') }} team record holders.</div>
                            <a title="Lakewood Ranch Swim Team" class="uk-button uk-button-primary" href="{{ asset('pdf/Swim_Team_Record_Holders.pdf') }}" download="Swim_Team_Record_Holders.pdf">Download</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

