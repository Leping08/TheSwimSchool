@extends('layouts.app-uikit')

@section('seo')
    <title>The North River Swim Team | Parrish Swimming | The Swim School Florida</title>
    <meta name="description" content="The Swim School near Parrish Florida invites you to come join our team! The North RIver Swim Team is holding tryouts at the River Wildnerness Country Club. Sign up for tryouts today."/>
@endsection

@section('heading')
    North River Swim Team
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
                        {{--<div class="uk-dropcap uk-margin">--}}
                            {{--<p>Registration is now open for our 2019 pre-season Swim--}}
                                {{--Club which will take place at our Harrison Ranch pool location.--}}
                                {{--To register, check out our <a href="/lessons/Flying%20Fish%20Level%20(Youth%20Advanced%20-%20Swim%20Club)">Flying Fish Swim Club for 6-8 year olds</a> and our <a href="/lessons/Shark%20Level%20(Youth%20Advanced%20-%20Swim%20Club)">Shark Swim Club for ages 9 years up</a>.--}}
                                {{--Stay up to date with everything we are doing on our <a href="https://www.facebook.com/North-River-Rapids-Swim-Team-209249439805502/" target="_blank">Facebook page</a>.--}}
                            {{--</p>--}}
                        {{--</div>--}}
                        {{--<div class="uk-margin">--}}
                            {{--<div class="uk-child-width-auto uk-grid-small uk-grid uk-grid-stack" uk-grid="">--}}
                                {{--<div class="uk-first-column">--}}
                                    {{--<a class="el-link uk-icon-button uk-icon" href="https://www.facebook.com/North-River-Rapids-Swim-Team-209249439805502/" target="_blankß" uk-icon="icon: facebook;">--}}
                                        {{--<svg width="20" height="20" viewBox="0 0 20 20"--}}
                                             {{--xmlns="http://www.w3.org/2000/svg" data-svg="facebook">--}}
                                            {{--<path d="M11,10h2.6l0.4-3H11V5.3c0-0.9,0.2-1.5,1.5-1.5H14V1.1c-0.3,0-1-0.1-2.1-0.1C9.6,1,8,2.4,8,5v2H5.5v3H8v8h3V10z"></path>--}}
                                        {{--</svg>--}}
                                    {{--</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
{{--                        <div>--}}
{{--                            <h2 class="uk-heading-line"><span>2019 Swim Team Tryouts</span></h2>--}}
{{--                            <ul class="uk-list uk-list-bullet">--}}
{{--                                <li>Tuesday, April 16th at 6:30PM</li>--}}
{{--                                <li>Wednesday, April 17th at 6:30PM</li>--}}
{{--                                <li>Saturday, April 20th at 9:00AM</li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
                        <div>
                            <h2 class="uk-heading-line"><span>2019 Swim Team Season</span></h2>
                            {{--<p>The North River Swim Team practices at the <a title="Parrish swim team" target="_blank" href="http://www.riverwildernesscc.com/">River Wilderness Country Club</a> and competes in the Suncoast Swim League, a seasonal developmental league that runs September 5th - October 31st.</p>--}}
                            <p>Season Runs Wednesday, May 1st- Wednesday, July 31st and is held at the River Wilderness Golf & Country Club pool.</p>
                        </div>
{{--                        <div>--}}
{{--                            <p><strong>There is no fee to tryout for the swim team. Tryouts are held at the River Wilderness Golf & Country Club pool.</strong></p>--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <!-- TODO: Add tryout that lasts all season -->--}}
{{--                            <a class="uk-button uk-button-primary" href="/swim-team/tryouts">Sign Up for Tryouts</a>--}}
{{--                            <a class="uk-button uk-button-default" disabled>Registration Coming Soon</a>--}}
{{--                        </div>--}}
                    </div>
                </div>
                <div class="uk-grid-item-match uk-flex-middle uk-width-expand@m">
                    <div class="uk-panel">
                        <div class="uk-margin">
                            <img class="" alt="" src="/img/logos/north-river-rapids.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="uk-section-default uk-section-overlap uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid="">
                <div class="uk-width-1-1@m uk-first-column">
                    <h2 class="uk-heading-line">
                        <span>Groups &amp; Practice Schedules</span>
                    </h2>
                </div>
            </div>
            <div class="uk-grid-margin uk-grid" uk-grid="">
                <div class="uk-width-expand@m uk-first-column">
                    <div class="uk-margin">
                        <img class="uk-border-rounded uk-box-shadow-large" alt="" src="/img/swim-team/2018-class.jpg">
                    </div>
                </div>
                <div class="uk-grid-item-match uk-flex-middle uk-width-2-3@m">
                    <div class="uk-panel">
                        <div class="uk-margin">Swim team tryout will determine group placement.</div>
                        <ul class="uk-list uk-list-bullet">
                            <li><b>Ripple:</b> Tues/Thurs 6PM-6:30PM</li>
                            <li><b>Splash:</b> Mon/Wed/Fri 5PM-5:45PM</li>
                            <li><b>Waves:</b> Mon/Wed/Fri 5:45PM-6:45PM, Sat 9:30AM-10:30AM</li>
                            <li><b>Rapids:</b> Mon/Tues/Wed/Thurs 6:30PM-7:45PM, Sat 8AM-9:30AM</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="uk-section-default uk-section-overlap uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-width-1-1@m uk-margin-top">
                <h2 class="uk-heading-line"><span>Swim Meet Schedule</span></h2>
                <div class="uk-child-width-expand@s" uk-grid>
                    <div>
                        <div class="uk-margin">Download the 2019 swim meet schedule. All swim meets are optional but participation is highly encouraged. All swim practices will be cancelled on days when a swim meet occurs</div>
                        <a title="Lakewood Ranch Swim Team" class="uk-button uk-button-primary" href="pdf/NRST_2019_Swim_Meet_Schedule.pdf" download="NRST_2019_Swim_Meet_Schedule.pdf">Download</a>
                    </div>
                    {{--                    <div>--}}
                    {{--                        <h3 class="el-title uk-margin uk-heading-bullet">Waves & Rapids Groups Schedule</h3>--}}
                    {{--                        <a title="Parrish Swim Team" class="uk-button uk-button-primary" href="pdf/NRST_Waves_&_Rapids_Groups_2018_Swim_Meet_&_Special_Events_Schedule.pdf" download="NRST_Waves_&_Rapids_Groups_2018_Swim_Meet_&_Special_Events_Schedule.pdf">Download</a>--}}
                    {{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>


    <div class="uk-section-default uk-section-overlap uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid="">
                <div class="uk-width-1-1@m uk-first-column">
                    <h2 class="uk-heading-line">
                        <span>Season Pricing</span>
                    </h2>
                </div>
            </div>
            <div class="uk-grid-margin uk-grid" uk-grid="">
                <div class="uk-grid-item-match uk-flex-middle uk-width-2-3@m uk-first-column">
                    <div class="uk-panel">
                        <div class="uk-margin">No Registration Fees! 10% Discount for River Wilderness Country Club Members (Must provide ID number for verification). 10% Multiple Child Discount. Each child will receive one free team swim cap and team t-shirt.</div>
                        <ul class="uk-list uk-list-bullet">
                            <li><b>Ripple:</b> $200</li>
                            <li><b>Splash:</b> $220</li>
                            <li><b>Waves:</b> $280</li>
                            <li><b>Rapids:</b> $340</li>
                        </ul>
                    </div>
                </div>

                <div class="uk-grid-item-match uk-flex-middle uk-width-expand@m">
                    <div class="uk-panel">
                        <div class="uk-margin">
                            <img class="uk-border-rounded uk-box-shadow-large" alt="" src="/img/thank-you/breast-stroke.jpg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
                                    <a title="Contact {{{$coach->name}}}" class="uk-button uk-button-default" href="tel:+1{{{$coach->phone}}}"><span uk-icon="icon: receiver;" class="uk-margin-small-right"></span> {{$coach->phone}}</a>
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
@endsection

