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
                            <p>The Parrish Bull Sharks swim team is located at the Lincoln Aquatic Center, 715 17th St. E Palmetto, Florida 34221.</p>
                            <div class="uk-card uk-card-default">
                                <iframe height="300" class="uk-width-1-1" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q={{urlencode(config('swim-team.google-maps-query'))}}&key={{config('google.maps.api_key')}}&zoom=12" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="uk-grid-margin uk-grid" uk-grid="">
                <div class="uk-grid-item-match uk-flex-middle uk-width-3-4@m uk-first-column">
                    <div class="uk-panel">
                        <h2 class="uk-heading-line"><span>Tryouts</span></h2>
                        <div class="uk-dropcap uk-margin">
                            <p>
                                Come join our team! We are a year round swim team with four program levels based on age and ability. All interested participants must register for and complete one of our available tryout sessions. There is no fee to tryout for the team. Each tryout session will take approximately one hour.
                            </p>
                            <p>
                                <b>Minimum Requirement</b>: Each child must be able to swim at least one full individual length without stopping (25 yards) of each of the four competitive swim strokes (freestyle, backstroke, breaststroke, and butterfly) to be eligible for participation on the team. Each stroke will be demonstrated at the tryout prior to having the children attempt them.
                            </p>
                            
                            {{-- <p>
                                Need to learn the strokes first? We have <a href="{{ route('groups.lessons.index') }}">group</a> and <a href="{{ route('private_lesson.index') }}">private swim lesson</a> options available now to get your child ready for their tryout.
                            </p> --}}
                            {{-- <p>
                                Registration for swim team tryouts opens on May 1st. All interested participants including returning swim team members must register and attend one of the available tryout options. There is no fee to tryout for the swim team. Tryouts are being held at our indoor pool location, Realhab Physical Therapy, Aquatics & Wellness Center, 12159 US-301, Parrish (while the Lincoln Aquatics Center construction is being completed). Each tryout session will take approximately one hour.
                            </p>
                            <ul class="uk-list uk-list-bullet">
                                <li>Tuesday, May 17th 7:15PM</li>
                                <li>Thursday, May 19th 7:15PM</li>
                                <li>Friday, May 20th 4:30PM</li>
                                <li>Friday, May 20th 5:30PM</li>
                                <li>Friday, May 20th 6:30PM</li>
                            </ul> --}}
                            <div>
                                <a class="uk-button uk-button-primary" href="{{ route('swim-team.tryouts.index') }}">Sign Up for Tryouts</a>
                            </div>
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
            {{-- <div class="uk-grid-margin uk-grid">
                <div class="uk-grid-item-match uk-flex-middle uk-width-1-1@m uk-first-column">
                    <div>
                        <div>
                            <h2 class="uk-heading-line"><span>Tryouts</span></h2>
                            <p>
                                Registration for swim team tryouts is now open. There is no fee to tryout for the swim team. Tryouts are held at the River Wilderness Golf & Country Club pool. Select one tryout from the three available options.
                                <strong>All interested participants must sign up for and attend one of the team tryouts. There is no fee to tryout for the swim team.</strong>
                            </p>
                            <ul class="uk-list uk-list-bullet">
                                <li>Saturday, May 1st at 1:30PM</li>
                                <li>Tuesday, May 4th at 5:30PM</li>
                                <li>Thursday, May 6th at 6:30PM</li>
                            </ul>
                            <p>
                                *Minimum Requirement: Each child must be able to swim at least one full individual length without stopping (25 meters) of each of the four competitive swim strokes (freestyle, backstroke, breaststroke, and butterfly) to be eligible for participation on the team. Each stroke will be demonstrated at the tryout prior to having the children attempt them.
                            </p>
                        </div>
                        <div>
                            <h2 class="uk-heading-line"><span>2019 Fall Swim Team Season</span></h2>
                            <p>The {{ config('swim-team.name') }} practices at the <a title="{{ config('swim-team.full-name') }}" target="_blank" href="http://www.riverwildernesscc.com/">River Wilderness Country Club</a> and competes in the Suncoast Swim League, a seasonal developmental league that runs September 5th - October 31st.</p>
                            <p>Season Runs Tuesday, September 3rd - Wednesday, October 30th and is held at the River Wilderness Golf & Country Club pool.</p>
                        </div>
                        <div>
                            <a class="uk-button uk-button-primary" href="{{ route('swim-team.tryouts.index') }}">Sign Up for Tryouts</a>
                            <a class="uk-button uk-button-default" disabled>Registration Coming Soon</a>
                        </div>
                    </div>
                </div>
            </div> --}}
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
                        <span>Pricing</span>
                    </h2>
                </div>
            </div>
            <div class="uk-grid-margin uk-grid" uk-grid="">
                <div class="uk-grid-item-match uk-flex-middle uk-width-2-3@m uk-first-column">
                    <div class="uk-panel">
                        <div class="uk-margin">
                            There is a $100 Registration/Apparel Fee per swimmer. As part of this fee, each swimmer will receive one team swimsuit, cap, t-shirt, water bottle and drawstring bag.
                        </div>
                        <div class="uk-margin">
                            A recurring monthly fee will be applied on the 1st of each month per swimmer based on their assigned program level. A multiple child discount of 10% will be applied when applicable. The monthly fees are based on the current practice schedule frequency and duration.
                        </div>
                        <ul class="uk-list uk-list-bullet">
                            <li><b>White Team 1:</b> $125</li>
                            <li><b>White Team 2:</b> $125</li>
                            <li><b>Gray Team:</b> $135</li>
                            <li><b>Blue Team:</b> $150</li>
                        </ul>
                        <div class="uk-margin">*Parent Non-Volunteer Fee per swimmer (optional): $100</div>
                        {{-- <div class="uk-margin">
                            You can find all official {{ config('swim-team.name') }} apparel for the swim season at our team apparel store below.
                        </div>
                        <a class="uk-button uk-button-primary" target="_blank" href="https://www.destinationathlete.com/teams/store.aspx?team=2159&dept=2173">Team Apparel Store</a> --}}
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
            <div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid="">
                <div class="uk-width-1-1@m uk-first-column">
                    <h2 class="uk-heading-line">
                        <span>Practice Schedules</span>
                    </h2>
                </div>
            </div>
            <div class="uk-grid-margin uk-grid" uk-grid="">
                <div class="uk-grid-item-match uk-flex-middle uk-width-2-3@m uk-first-column">
                    <div class="">
                        <div class="uk-panel uk-margin-large-bottom">
                            <h2>
                                School Year Practice Schedule
                            </h2>
                            <div class="uk-margin">
                                Runs <b>August-May</b> and practices are offered five days per week for all practice levels.
                            </div>
                            <ul class="uk-list uk-list-bullet">
                                <li><b>White Team 1:</b> M/W 4:30PM-5:15PM OR 5:45PM-6:30PM, T/TH 4:30PM-5:15PM & Sat 9:30AM-10:15AM</li>
                                <li class="uk-margin-left"><b>Goal:</b> 2-3 practices per week</li>
                                <li><b>White Team 2:</b> M/W 4:30PM-5:15PM OR 5:45PM-6:30PM, T/TH 4:30PM-5:15PM & Sat 9:30AM-10:15AM</li>
                                <li class="uk-margin-left"><b>Goal:</b> 3-4 practices per week</li>
                                <li><b>Gray Team:</b> M/W 4:30PM-5:30PM OR 5:30PM-6:30PM, T/TH 5:30PM-6:30PM & Sat 9:30AM-10:30AM</li>
                                <li class="uk-margin-left"><b>Goal:</b> 3-4 practices per week</li>
                                <li><b>Blue Team:</b> M/W 5:00PM-6:30PM, T/TH 5:15PM-6:30PM w/ Dryland 5:00PM-5:15PM & Sat 9:30AM-11:00AM</li>
                                <li class="uk-margin-left"><b>Goal:</b> 3-5 practices per week</li>
                            </ul>
                        </div>
                        
                        <div class="uk-panel">
                            <h2>
                                Summer Practice Schedule
                            </h2>
                            <div class="uk-margin">
                                Runs <b>June 3rd-August 3rd</b> and practices are offered five days per week for all practice levels
                            </div>
                            <ul class="uk-list uk-list-bullet">
                                <li><b>White Team 1:</b> Mon/Wed/Fri 8:30AM-9:15AM, Tues/Thurs 8:00AM-8:45AM or 10:15AM-11:00AM</li>
                                <li class="uk-margin-left"><b>Goal:</b> 2-3 practices per week</li>
                                <li><b>White Team 2:</b> Mon/Wed/Fri 9:15AM-10:00AM, Tues/Thurs 8:00AM-8:45AM or 10:15AM-11:00AM</li>
                                <li class="uk-margin-left"><b>Goal:</b> 3-4 practices per week</li>
                                <li><b>Gray Team:</b> Mon/Wed/Fri 8:30AM-9:30AM, Tues/Thurs 8:45AM-9:45AM or 9:15AM-10:15AM</li>
                                <li class="uk-margin-left"><b>Goal:</b> 3-4 practices per week</li>
                                <li><b>Blue Team:</b> Mon/Wed/Fri 8:30AM-10:00AM (Dryland: 8:15AM-8:30AM), Tues/Thurs 8:00AM-9:15AM or 9:45AM-11:00AM</li>
                                <li class="uk-margin-left"><b>Goal:</b> 4-5 practices per week</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="uk-grid-item-match uk-flex-middle uk-width-expand@m">
                    <div class="uk-panel">
                        <div class="uk-margin">
                            <img class="uk-border-rounded uk-box-shadow-large" alt="Swim Instruction Parrish" src="{{ asset('/img/swim-team/2021-class.jpg') }}">
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
                                <div class="uk-grid uk-flex-middle">
                                    @if ($coach->image_url)
                                        <div class="uk-width-1-1@s uk-width-1-6@m uk-width-1-6@l uk-width-1-6@xl">
                                            <div class="uk-margin-bottom uk-margin-top">
                                                <img class="uk-border-rounded uk-box-shadow-large" src="{{$coach->image_url}}" alt="{{ config('swim-team.name') }}" srcset="">
                                            </div>
                                        </div>
                                        <div class="uk-width-1-1@s uk-width-5-6@m uk-width-5-6@l uk-width-5-6@xl">
                                            <div>
                                                <div>{{$coach->bio}}</div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="uk-width-1-1">
                                            <div>
                                                <div>{{$coach->bio}}</div>
                                            </div>
                                        </div>
                                    @endif
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
                            <div class="uk-margin">Download the swim meet schedule.</div>
                            <a target="_blank" title="Parrish Swim Team" class="uk-button uk-button-primary" href="{{ asset('pdf/PBS_Swim_Meet_Schedule_2023-2024.pdf') }}" download="PBS_Swim_Meet_Schedule_2023-2024.pdf">Download</a>
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
                    <div class="uk-grid-item-match uk-flex-middle uk-width-2-3@m uk-first-column">
                        <div class="">
                            <div>
                                <div class="uk-margin">Check out the current {{ config('swim-team.name') }} swim team record holders.</div>
                            </div>
                            <div>
                                <a title="Parrish Swim Team" class="uk-button uk-button-primary uk-margin-right" href="{{ asset('pdf/PBS_Team_Records.pdf') }}" download="PBS_Team_Records.pdf">Download Records</a>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-expand@m">
                        <div class="uk-margin">
                            <img class="uk-border-rounded uk-box-shadow-large" alt="Kids Swimming near Bradenton" src="{{ asset('/img/swim-team/backstroke.jpg') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

