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
                            <p>The {{ config('swim-team.full-name') }} is located at the Lincoln Aquatic Center, {{ config('swim-team.address') }}.</p>
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
                        <h2 class="uk-heading-line"><span>Tryouts/Level Placement</span></h2>
                        <div class="uk-dropcap uk-margin">
                            <p>
                                Come join our team! We are a year round swim club offering three developmental levels and three USA competitive levels within our program. All those interested in joining our team must register for and complete one of our available tryout/level placement sessions. There is no fee for this. Each tryout/level placement session will take approximately one hour.
                            </p>
                            <p>
                                <b>Minimum Requirement</b>: To be eligible for participation on our swim team, each child must be able to complete a 100 yard IM (Individual Medley) independently without stopping. This is 25 yards of each of the four competitive swim strokes in the following order: butterfly, backstroke, breaststroke, and freestyle.
                            </p>
                            <p>
                                Need to learn the strokes and/or build up your stamina first to be prepared for a tryout? We have <a href="{{ route('groups.lessons.index') }}">group</a> and <a href="{{ route('private_lesson.index') }}">private swim lesson</a> options available to get your child tryout ready!
                            </p>
                            <div>
                                <a class="uk-button uk-button-primary" href="{{ route('swim-team.tryouts.index') }}">SIGN UP FOR TRYOUTS</a>
                            </div>
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
                            <b>Registration/Apparel Fee:</b> There is a $100 Registration/Apparel Fee per swimmer. As part of this fee, each swimmer will receive a team drawstring bag with one team swimsuit, one team t-shirt, and two team swim caps.
                        </div>
                        <div class="uk-margin">
                            <b>Monthly Program Fees:</b> A recurring monthly fee will be applied on the 1st of each month per swimmer based on their assigned program level. A multiple child discount of 10% will be applied when applicable. The monthly fees are based on the current practice schedule frequency and duration.
                        </div>
                        <div class="uk-margin">
                            <b>Developmental Levels:</b>
                        </div>
                        <ul class="uk-list uk-list-bullet">
                            <li><b>White Team:</b> $125</li>
                            <li><b>Gray Team:</b> $135</li>
                            <li><b>Blue Team:</b> $145</li>
                        </ul>
                        <div class="uk-margin">
                            There are no additional fees for developmental swim meets. However, there is a parent volunteer requirement for all developmental swim meets attended.
                        </div>
                        <div class="uk-margin">
                            <b>USA Competitive Levels:</b>
                        </div>
                        <ul class="uk-list uk-list-bullet">
                            <li><b>Bronze Team:</b> $160</li>
                            <li><b>Silver Team:</b> $175</li>
                            <li><b>Gold Team:</b> $175</li>
                        </ul>
                        <div class="uk-margin">
                            <b>USA Membership Fee:</b> For all USA Competitive Levels there is a required annual USA membership and fee ($97) that must be completed and paid online at the time of joining the team prior to attending the first swim practice.
                        </div>
                        <div class="uk-margin">
                            <b>Swim Meet Assessment Fees:</b> For all USA Competitive Levels there is a required quarterly swim meet assessment fee charged on January 15th, April 15th, July 15th and October 15th as follows to cover swim meet entry costs.
                        </div>
                        <ul class="uk-list uk-list-bullet">
                            <li><b>Bronze Team:</b> $150 (Must attend at least 5 meets per year.)</li>
                            <li><b>Silver Team:</b> $175 (Must attend at least 8 meets per year.)</li>
                            <li><b>Gold Team:</b> $200 (Must attend at least 10 meets per year.)</li>
                        </ul>
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
                                Runs <b>August 12th-May 21st</b>
                            </div>
                            <div class="uk-margin">
                                <b>Developmental Team</b>
                            </div>
                            <ul class="uk-list uk-list-bullet">
                                <li>
                                    <b>White Team:</b> Mon/Wed 4:30PM-5:15PM &amp; Tues/Thurs 6:15PM-7:00PM &amp; Sat 9:00AM-9:45AM<br>
                                </li>
                                <li class="uk-margin-left"><b>Goal:</b> 2-3 practices per week</li>
                                <li>
                                    <b>Gray Team:</b> Mon/Wed 4:30PM-5:30PM &amp; Tues/Thurs 6:00PM-7:00PM &amp; Sat 8:00AM-9:00AM<br>
                                </li>
                                <li class="uk-margin-left"><b>Goal:</b> 3-4 practices per week</li>
                                <li>
                                    <b>Blue Team:</b> Mon/Wed 4:30PM-5:45PM &amp; Tues/Thurs 5:45PM-7:00PM &amp; Sat 8:00AM-9:15AM<br>
                                </li>
                                <li class="uk-margin-left"><b>Goal:</b> 3-4 practices per week</li>
                            </ul>
                            <div class="uk-margin">
                                <b>USA Competitive Team</b>
                            </div>
                            <ul class="uk-list uk-list-bullet">
                                <li>
                                    <b>Bronze Team:</b> Mon/Wed 5:30PM-7:00PM &amp; Tues/Thurs 4:30PM-6:00PM &amp; Sat 8:00AM-9:30AM<br>
                                </li>
                                <li class="uk-margin-left"><b>Goal:</b> 3-5 practices per week</li>
                                <li>
                                    <b>Silver Team:</b> Mon/Wed 5:00PM-7:00PM &amp; Tues/Thurs 5:00AM-6:30AM &amp; Tues/Thurs 4:30PM-6:30PM &amp; Sat 8:00AM-10:00AM (Be prepared for dry land training every practice)<br>
                                </li>
                                <li class="uk-margin-left"><b>Goal:</b> 4-6 practices per week</li>
                                <li>
                                    <b>Gold Team:</b> Mon/Wed 5:00PM-7:00PM &amp; Tues/Thurs 5:00AM-6:30AM &amp; Tues/Thurs 4:30PM-6:30PM &amp; Sat 8:00AM-10:00AM (Be prepared for dry land training every practice)<br>
                                </li>
                                <li class="uk-margin-left"><b>Goal:</b> 5-7 practices per week</li>
                            </ul>
                        </div>
                        <div class="uk-panel uk-margin-large-top">
                            <h2>
                                Summer Practice Schedule
                            </h2>
                            <div class="uk-margin">
                                Runs <b>June 1st-August 1st</b>
                            </div>
                            <div class="uk-margin">
                                <b>Developmental Team</b>
                            </div>
                            <ul class="uk-list uk-list-bullet">
                                <li>
                                    <b>White Team:</b> Mon/Tues/Wed/Thur/Fri 9:00AM-9:45AM &amp; Tues/Thurs 5:00PM-5:45PM<br>
                                </li>
                                <li class="uk-margin-left"><b>Goal:</b> 2-3 practices per week</li>
                                <li>
                                    <b>Gray Team:</b> Mon/Tues/Wed/Thur/Fri 9:00AM-10:00AM &amp; Tues/Thurs 5:00PM-6:00PM<br>
                                </li>
                                <li class="uk-margin-left"><b>Goal:</b> 3-4 practices per week</li>
                                <li>
                                    <b>Blue Team:</b> Mon/Tues/Wed/Thur/Fri 8:30AM-9:45AM &amp; Tues/Thurs 5:00PM-6:15PM<br>
                                </li>
                                <li class="uk-margin-left"><b>Goal:</b> 3-4 practices per week</li>
                            </ul>
                            <div class="uk-margin">
                                <b>USA Competitive Team</b>
                            </div>
                            <ul class="uk-list uk-list-bullet">
                                <li>
                                    <b>Bronze Team:</b> Mon/Tues/Wed/Fri 7:00AM-8:30AM, Tues/Thurs 5:00PM-6:30PM, &amp; *Thurs 6:30AM-8:00AM @ GT Bray for Long Course Practice<br>
                                </li>
                                <li class="uk-margin-left"><b>Goal:</b> 3-5 practices per week</li>
                                <li>
                                    <b>Silver Team:</b> Mon/Tues/Wed/Fri 7:00AM-9:00AM, Tues/Thurs 5:00PM-6:00PM, &amp; *Thurs 6:30AM-8:00AM @ GT Bray for Long Course Practice (Be prepared for dry land training every practice)<br>
                                </li>
                                <li class="uk-margin-left"><b>Goal:</b> 4-6 practices per week</li>
                                <li>
                                    <b>Gold Team:</b> Mon/Tues/Wed/Fri 7:00AM-9:00AM, Tues/Thurs 5:00PM-6:00PM, &amp; *Thurs 6:30AM-8:00AM @ GT Bray for Long Course Practice (Be prepared for dry land training every practice)<br>
                                </li>
                                <li class="uk-margin-left"><b>Goal:</b> 5-7 practices per week</li>
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
                <h2 id="swim-meet-schedules" class="uk-heading-line"><span>Swim Meet Schedules</span></h2>
                <div class="uk-child-width-expand@s" uk-grid>
                    <div class="uk-width-expand@m uk-first-column">
                        <div class="uk-margin">
                            <img class="uk-border-rounded uk-box-shadow-large" alt="Swim Team near Ellenton" src="{{ asset('/img/swim-team/new-log-cap.jpg') }}">
                        </div>
                    </div>
                    <div class="uk-grid-item-match uk-flex-middle uk-width-2-3@m">
                        <div>
                            <div class="uk-margin">
                                <div class="uk-margin">
                                    Download the {{ config('swim-team.name') }} developmental and/or USA competitive swim meet schedules below.
                                </div>
                                <div>
                                    <a title="Developmental Meet Schedule" class="uk-button uk-button-primary" href="{{ Storage::disk('s3')->url('pdf/PBS_Swim_Meet_Schedule.pdf') }}" target="_blank" rel="noopener" download="PBS_Swim_Meet_Schedule.pdf">Developmental Meet Schedule</a>
                                    @auth
                                    <button class="uk-button uk-button-secondary uk-margin-small-left" type="button" uk-toggle="target: #edit-meet-schedule-modal">Edit</button>
                                    <div id="edit-meet-schedule-modal" uk-modal>
                                        <div class="uk-modal-dialog uk-modal-body">
                                            <h2 class="uk-modal-title">Upload New Meet Schedule PDF</h2>
                                            <form method="POST" action="{{ route('swim-team.meet-schedule.upload') }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="uk-margin">
                                                    <input class="uk-input" type="file" name="meet_schedule_pdf" accept="application/pdf" required>
                                                </div>
                                                <button class="uk-button uk-button-primary" type="submit">Upload</button>
                                                <button class="uk-button uk-button-secondary uk-modal-close" type="button">Cancel</button>
                                            </form>
                                        </div>
                                    </div>
                                    @endauth
                                </div>
                                <div class="uk-margin-small-top">
                                    <a title="USA Competitive Meet Schedule" class="uk-button uk-button-primary" href="{{ Storage::disk('s3')->url('pdf/PBS_USA_Competitive_Swim_Meet_Schedule.pdf') }}" target="_blank" rel="noopener" download="PBS_USA_Competitive_Swim_Meet_Schedule.pdf">USA Competitive Meet Schedule</a>
                                    @auth
                                    <button class="uk-button uk-button-secondary uk-margin-small-left" type="button" uk-toggle="target: #edit-usa-meet-schedule-modal">Edit</button>
                                    <div id="edit-usa-meet-schedule-modal" uk-modal>
                                        <div class="uk-modal-dialog uk-modal-body">
                                            <h2 class="uk-modal-title">Upload New USA Competitive Meet Schedule PDF</h2>
                                            <form method="POST" action="{{ route('swim-team.usa-meet-schedule.upload') }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="uk-margin">
                                                    <input class="uk-input" type="file" name="usa_meet_schedule_pdf" accept="application/pdf" required>
                                                </div>
                                                <button class="uk-button uk-button-primary" type="submit">Upload</button>
                                                <button class="uk-button uk-button-secondary uk-modal-close" type="button">Cancel</button>
                                            </form>
                                        </div>
                                    </div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="uk-section-default uk-section-overlap uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-width-1-1@m uk-margin-top">
                <h2 id="record_holders" class="uk-heading-line"><span>Record Holders</span></h2>
                <div class="uk-grid-margin uk-grid" uk-grid="">
                    <div class="uk-grid-item-match uk-flex-middle uk-width-2-3@m uk-first-column">
                        <div class="">
                            <div class="uk-margin"> 
                                Check out the current {{ config('swim-team.name') }} swim team record holders.
                            </div>
                            <div>
                                <a title="Parrish Swim Team" class="uk-button uk-button-primary uk-margin-right" href="{{ Storage::disk('s3')->url('pdf/PBS_Team_Records.pdf') }}" target="_blank" rel="noopener" download="PBS_Team_Records.pdf">Download Records</a>
                                @auth
                                <button class="uk-button uk-button-secondary uk-margin-small-left" type="button" uk-toggle="target: #edit-records-modal">Edit</button>
                                <div id="edit-records-modal" uk-modal>
                                    <div class="uk-modal-dialog uk-modal-body">
                                        <h2 class="uk-modal-title">Upload New Records PDF</h2>
                                        <form method="POST" action="{{ route('swim-team.records.upload') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="uk-margin">
                                                <input class="uk-input" type="file" name="records_pdf" accept="application/pdf" required>
                                            </div>
                                            <button class="uk-button uk-button-primary" type="submit">Upload</button>
                                            <button class="uk-button uk-button-secondary uk-modal-close" type="button">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                                @endauth
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

