@extends('layouts.app-uikit')

@section('seo')
    <title>The {{ config('swim-team.name') }} | Parrish Swimming | The Swim School Florida</title>
    <meta name="description" content="The Swim School near Parrish Florida invites you to come join our team! The {{ config('swim-team.name') }} is holding tryouts at the River Wilderness Country Club. Sign up for tryouts today."/>
@endsection

@section('heading')
    {{ config('swim-team.name') }} Swim Team
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
                <div class="uk-width-1-1@m uk-section-default uk-section-overlap uk-section uk-section-small">
                    <div class="uk-container">
                        <div class="uk-width-1-1@m">
                            <h2 class="uk-heading-line"><span>Location</span></h2>
                            <p>Starting Wednesday, June 1st, 2022, swim team will take place in an outdoor pool at the new Lincoln Aquatics Center in Palmetto, Florida.</p>
                            <div class="uk-card uk-card-default">
                                <iframe height="300" class="uk-width-1-1" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=Lincoln%20Park%20715%2017th%20Street%20East%20Palmetto,%20Florida%2034221&key={{config('google.maps.api_key')}}&zoom=12" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="uk-grid-margin uk-grid" uk-grid="">
                <div class="uk-grid-item-match uk-flex-middle uk-width-3-4@m uk-first-column">
                    <div class="uk-panel">
                        <h2 class="uk-heading-line"><span>2022 {{ config('swim-team.name') }} Swim Team Tryouts Information</span></h2>
                        <div class="uk-dropcap uk-margin">
{{--                            <p>--}}
{{--                                Our 2021 spring pre-season training has begun! For more information and to register, check out our <a title="Swimming Team Parrish" href="/lessons/Flying%20Fish%20Level%20(Youth%20Advanced%20-%20Swim%20Club)">Flying Fish Swim Club</a>--}}
{{--                                for 6-8 year olds ($100 per session) and our <a title="Parrish Swim Club" href="/lessons/Shark%20Level%20(Youth%20Advanced%20-%20Swim%20Club)">Shark Swim Club</a> for ages 9 years & up ($125 per session).--}}
{{--                                Sessions are held weekday evenings. Information regarding our 2021 Summer Swim Team tryouts and season will be available by April 15th.--}}
{{--                                Stay up to date with everything we are doing on our <a title="Parrish Swim Team Facebook" href="https://www.facebook.com/Parrish-Bull-Sharks-Swim-Team-209249439805502/" target="_blank">Facebook page</a>.--}}
{{--                            </p>--}}
                            {{-- <p>
                                The {{ config('swim-team.full-name') }} competes in a seasonal, developmental swim league.
                                The summer season runs <strong>Tuesday, June 1st - Sunday, August 2nd</strong> and practices are held at the River Wilderness Golf & Country Club pool.
                                Stay up to date with everything we are doing on our <a href="https://www.facebook.com/North-River-Rapids-Swim-Team-209249439805502/" target="_blank">Facebook page</a>.
                            </p>
                            <p>
                                Need some practice first? Join in on our spring pre-season Swim Team. For more information and to register, check out our <a href="/lessons/Flying%20Fish%20Level%20(Youth%20Advanced%20-%20Swim%20Club)">Flying Fish Swim Club</a>
                                for 6-8 year olds ($100 per session) and our <a href="/lessons/Shark%20Level%20(Youth%20Advanced%20-%20Swim%20Club)">Shark Swim Club</a> for ages 9 years & up ($125 per session). Sessions are held weekday evenings.
                            </p>
                            <p>
                                Need to learn the strokes first? We have <a href="{{ route('groups.lessons.index') }}">group</a> and <a href="{{ route('private_lesson.index') }}">private swim lesson</a> options available now to get your child ready for their tryout.
                            </p> --}}
                            <p>
                                Registration for swim team tryouts opens on May 1st. All interested participants including returning swim team members must register and attend one of the available tryout options. There is no fee to tryout for the swim team. Tryouts are being held at our indoor pool location, Realhab Physical Therapy, Aquatics & Wellness Center, 12159 US-301, Parrish (while the Lincoln Aquatics Center construction is being completed). Each tryout session will take approximately one hour.
                            </p>
                            <ul class="uk-list uk-list-bullet">
                                <li>Tuesday, May 17th 6:30PM</li>
                                <li>Thursday, May 19th 7:30PM</li>
                                <li>Friday, May 20th 4:30PM</li>
                                <li>Friday, May 20th 5:30PM</li>
                                <li>Friday, May 20th 6:30PM</li>
                            </ul>
                            <p>
                                *Minimum Requirement: Each child must be able to swim at least one full individual length without stopping (25 yards) of each of the four competitive swim strokes (freestyle, backstroke, breaststroke, and butterfly) to be eligible for participation on the team. Each stroke will be demonstrated at the tryout prior to having the children attempt them.
                            </p>
                            <p>
                                Need some practice first? We have <a href="{{ route('groups.lessons.index') }}">group</a> and <a href="{{ route('private_lesson.index') }}">private swim lesson</a> options available to get your child ready for their tryout.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="uk-grid-item-match uk-flex-middle uk-width-expand@m">
                    <div class="uk-panel">
                        <div class="uk-margin">
                            <img class="" alt="Parrish Swim Lessons" src="{{ asset('/img/logos/parrish-bull-sharks.png') }}">
                        </div>
                    </div>
                </div>
            </div>
{{--            <div class="uk-grid-margin uk-grid">--}}
{{--                <div class="uk-grid-item-match uk-flex-middle uk-width-1-1@m uk-first-column">--}}
{{--                    <div>--}}
{{--                        <div>--}}
{{--                            <h2 class="uk-heading-line"><span>Tryouts</span></h2>--}}
{{--                            <p>--}}
{{--                                Registration for swim team tryouts is now open. There is no fee to tryout for the swim team. Tryouts are held at the River Wilderness Golf & Country Club pool. Select one tryout from the three available options.--}}
{{--                                <strong>All interested participants must sign up for and attend one of the team tryouts. There is no fee to tryout for the swim team.</strong>--}}
{{--                            </p>--}}
{{--                            <ul class="uk-list uk-list-bullet">--}}
{{--                                <li>Saturday, May 1st at 1:30PM</li>--}}
{{--                                <li>Tuesday, May 4th at 5:30PM</li>--}}
{{--                                <li>Thursday, May 6th at 6:30PM</li>--}}
{{--                            </ul>--}}
{{--                            <p>--}}
{{--                                *Minimum Requirement: Each child must be able to swim at least one full individual length without stopping (25 meters) of each of the four competitive swim strokes (freestyle, backstroke, breaststroke, and butterfly) to be eligible for participation on the team. Each stroke will be demonstrated at the tryout prior to having the children attempt them.--}}
{{--                            </p>--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <h2 class="uk-heading-line"><span>2019 Fall Swim Team Season</span></h2>--}}
{{--                            <p>The {{ config('swim-team.name') }} practices at the <a title="{{ config('swim-team.full-name') }}" target="_blank" href="http://www.riverwildernesscc.com/">River Wilderness Country Club</a> and competes in the Suncoast Swim League, a seasonal developmental league that runs September 5th - October 31st.</p>--}}
{{--                            <p>Season Runs Tuesday, September 3rd - Wednesday, October 30th and is held at the River Wilderness Golf & Country Club pool.</p>--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <a class="uk-button uk-button-primary" href="{{ route('swim-team.tryouts.index') }}">Sign Up for Tryouts</a>--}}
{{--                            <a class="uk-button uk-button-default" disabled>Registration Coming Soon</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>


    {{-- <div class="uk-section-default uk-section-overlap uk-section uk-section-small">
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
                        <img class="uk-border-rounded uk-box-shadow-large" alt="Parrish Swim Team" src="{{ asset('/img/swim-team/2021-class.jpg') }}">
                    </div>
                </div>
                <div class="uk-grid-item-match uk-flex-middle uk-width-2-3@m">
                    <div class="uk-panel">
                        <div class="uk-margin">Swim team tryout will determine group placement.</div>
                        <ul class="uk-list uk-list-bullet">
                            <li><b>White Team 1:</b> Mon/Wed/Fri 5PM-5:45PM</li>
                            <li><b>White Team 2:</b> Tues/Thurs/Fri 5PM-5:45PM</li>
                            <li><b>Gray Team:</b> Mon/Wed/Fri 5:45PM-6:45PM</li>
                            <li><b>Blue Team:</b> Mon/Wed 6:45PM-7:45PM, Tues/Thurs 5:45PM-7:15PM</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}


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
                        <div class="uk-margin">The summer season runs Wednesday, June 1st - Saturday, July 30th. No Registration Fees! 10% Multiple Child Discount. Each child will receive one free team swim cap and team t-shirt. Price also includes swim meet entry fees and ribbons for the entire season (with the exception of the Suncoast Swim League championship meet fee) as well as end of season awards.</div>
                        <ul class="uk-list uk-list-bullet">
                            <li><b>White Team:</b> $250</li>
                            <li><b>Gray Team:</b> $310</li>
                            <li><b>Blue Team:</b> $450</li>
                        </ul>
                        <div class="uk-margin">*Parent Non-Volunteer Fee per swimmer per season (optional): $50</div>
                        <div class="uk-margin">
                            You can find all official {{ config('swim-team.name') }} apparel for the swim season at our team apparel store below.
                        </div>
                        <a class="uk-button uk-button-primary" target="_blank" href="https://www.destinationathlete.com/teams/store.aspx?team=2159&dept=2173">Team Apparel Store</a>
                    </div>
                </div>

                <div class="uk-grid-item-match uk-flex-middle uk-width-expand@m">
                    <div class="uk-panel">
                        <div class="uk-margin">
                            <img class="uk-border-rounded uk-box-shadow-large" alt="Swim Instruction Parrish" src="{{ asset('/img/swim-team/breaststroke.jpg') }}">
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
                                    <a title="Contact {{$coach->name}}" class="uk-button uk-button-default" title="Swim Instruction Parrish" href="tel:+1{{$coach->phone}}"><span uk-icon="icon: receiver;" class="uk-margin-small-right"></span> {{$coach->phone}}</a>
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
            <div class="uk-width-1-1@m uk-margin-top">
                <h2 class="uk-heading-line"><span>Swim Meet Schedule</span></h2>
                <div class="uk-child-width-expand@s" uk-grid>
                    <div class="uk-width-expand@m uk-first-column">
                        <div class="uk-margin">
                            <img class="uk-border-rounded uk-box-shadow-large" alt="Swim Team near Ellenton" src="{{ asset('/img/swim-team/new-log-cap.jpg') }}">
                        </div>
                    </div>
                    <div class="uk-grid-item-match uk-flex-middle uk-width-2-3@m">
                        <div>
                            <div class="uk-margin">Download the 2021 swim meet schedule. All swim meets are optional but participation is highly encouraged.</div>
                            <a title="Parrish Swim Team" class="uk-button uk-button-primary" href="{{ asset('pdf/PBS_2021_Swim_Meet_Schedule.pdf') }}" download="PBS 2021 Swim Meet Schedule.pdf">Download</a>
                        </div>
                    </div>
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
                            <img class="uk-border-rounded uk-box-shadow-large" alt="Kids Swimming near Bradenton" src="{{ asset('/img/swim-team/backstroke.jpg') }}">
                        </div>
                    </div>
                    <div class="uk-grid-item-match uk-flex-middle uk-width-2-3@m">
                        <div class="">
                            <div>
                                <div class="uk-margin">Check out the current {{ config('swim-team.name') }} swim team record holders.</div>
                            </div>
                            <div>
                                <a title="Parrish Swim Team" class="uk-button uk-button-primary uk-margin-left uk-margin-right" href="{{ asset('pdf/Boys_Record_Holders.pdf') }}" download="Swim Team Boys Record Holders.pdf">Boys Records</a>
                                <a title="Parrish Swim Team" class="uk-button uk-button-primary uk-margin-left uk-margin-right" href="{{ asset('pdf/Girls_Record_Holders.pdf') }}" download="Swim Team Girls Record Holders.pdf">Girls Records</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

