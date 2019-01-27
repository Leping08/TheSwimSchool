@extends('layouts.app-uikit')

@section('seo')
    <title>The North River Swim Team | Parrish Swimming | The Swim School Florida</title>
    <meta name="description" content="The Swim School near Parrish Florida invites you to come join our team! The North RIver Swim Team is holding tryouts at the River Wildnerness Country Club. Sign up for tryouts today."/>
@endsection

@section('heading')
    North River Swim Team
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-flex-middle uk-grid-margin uk-grid" uk-grid="">
                <div class="uk-width-3-4@m uk-first-column">
                    <div class="uk-dropcap">
                        <p>Bring your suit, goggles & towel and come join our team! The North River Swim Team practices at the River Wilderness Country Club and competes in a seasonal, developmental swim league. We are excited to announce our Fall Swim Club will run Wednesday, September 5th - Wednesday, October 31st!</p>
                    </div>
                    <div>
                        <h3 class="uk-heading-line"><span>2018 Fall Swim Club Tryout</span></h3>
                        <ul class="uk-list uk-list-bullet">
                            <li>August 27th at 5:45PM</li>
                        </ul>
                    </div>
                    <div>
                        <p><strong>There is no fee to tryout for the swim team.</strong></p>
                    </div>
                    {{--<div>--}}
                        {{--<p>The North River Swim Team practices at the <a title="Parrish swim team" target="_blank" href="http://www.riverwildernesscc.com/">River Wilderness Country Club</a> and competes in the Suncoast Swim League, a seasonal developmental league that runs September 5th - October 31st.</p>--}}
                    {{--</div>--}}
                    <div>
                        <!-- TODO: Add tryout that lasts all season -->
                        <a class="uk-button uk-button-primary" href="/swim-team/tryouts">Sign Up for Tryouts</a>
                        {{--<a class="uk-button uk-button-default" disabled>Registration Coming Soon</a>--}}
                    </div>
                </div>
                <div class="uk-width-1-4@m">
                    <div class="uk-margin">
                        <img src="/img/swim-team/dive.jpg" class="el-image uk-border-rounded uk-box-shadow-large" alt="Bradenton Learn to Swim">
                    </div>
                </div>
            </div>

            <div class="uk-width-1-1@m uk-margin-top">
                <h2 class="uk-heading-line"><span>Groups & Practice Schedules</span></h2>
                <p>Swim team tryout will determine group placement.</p>
                <ul class="uk-list uk-list-bullet">
                    <li><b>Ripple:</b> Mon/Wed 5PM-5:30PM</li>
                    <li><b>Splash:</b> Mon/Wed 5PM-5:45PM</li>
                    <li><b>Waves:</b> Mon/Wed 5:45PM-6:45PM</li>
                    <li><b>Rapids:</b> Mon/Tues/Wed 5:45PM-7:00PM</li>
                </ul>
            </div>

            <div class="uk-width-1-1@m uk-margin-top">
                <h2 class="uk-heading-line"><span>Season Pricing</span></h2>
                <p>No Registration Fees! 10% Discount for River Wilderness Country Club Members (Must provide ID number for verification). 10% Multiple Child Discount. Each child will receive one free team swim cap and team t-shirt.</p>
                <ul class="uk-list uk-list-bullet">
                    <li><b>Ripple:</b> $100</li>
                    <li><b>Splash:</b> $110</li>
                    <li><b>Waves:</b> $140</li>
                    <li><b>Rapids:</b> $170</li>
                </ul>
            </div>

            {{--<div class="uk-width-1-1@m uk-margin-top">--}}
                {{--<h2 class="uk-heading-line"><span>Season Schedule</span></h2>--}}
                {{--<div class="uk-text-center uk-child-width-expand@s" uk-grid>--}}
                    {{--<div>--}}
                        {{--<h3 class="el-title uk-margin uk-heading-bullet">Ripple & Splash Schedule</h3>--}}
                        {{--<a title="Lakewood Ranch Swim Team" class="uk-button uk-button-primary" href="pdf/NRST_Ripple_&_Splash_Groups_2018_Swim_Meet_&_Special_Event_Schedule.pdf" download="NRST_Ripple_&_Splash_Groups_2018_Swim_Meet_&_Special_Event_Schedule.pdf">Download</a>--}}
                    {{--</div>--}}
                    {{--<div>--}}
                        {{--<h3 class="el-title uk-margin uk-heading-bullet">Waves & Rapids Groups Schedule</h3>--}}
                        {{--<a title="Parrish Swim Team" class="uk-button uk-button-primary" href="pdf/NRST_Waves_&_Rapids_Groups_2018_Swim_Meet_&_Special_Events_Schedule.pdf" download="NRST_Waves_&_Rapids_Groups_2018_Swim_Meet_&_Special_Events_Schedule.pdf">Download</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            <div class="uk-width-1-1@m uk-margin-top">
                <h2 class="uk-heading-line"><span>Coaches</span></h2>
                <div class="uk-margin">
                    <ul uk-tab="connect: #js-350;animation: uk-animation-fade" class="uk-margin el-nav uk-tab">
                        <li aria-expanded="true" class="uk-active">
                            <a href="#">Hilary Koppenhaver</a>
                        </li>
                        {{--<li aria-expanded="false">--}}
                            {{--<a href="#">Matt Polk</a>--}}
                        {{--</li>--}}
                        {{--<li aria-expanded="false">--}}
                            {{--<a href="#">Isabella Ortiz</a>--}}
                        {{--</li>--}}
                        {{--<li aria-expanded="false">--}}
                            {{--<a href="#">Zach Maibach</a>--}}
                        {{--</li>--}}
                    </ul>

                    <ul id="js-350" class="uk-switcher" uk-height-match="row: false">
                        <li class="el-item">
                            <img src="">
                            <h3 class="el-title uk-margin uk-heading-bullet">Hilary Koppenhaver</h3>
                            <div class="el-content uk-margin">
                                <p>Hilary is originally from Pennsylvania and started swimming at the age of five. She continued competitively through college in Ohio where she earned a B.A. in Psychology. After receiving her degree in 2003, she returned to PA and worked part-time as a lifeguard, swim lesson instructor, and swim team coach in addition to having a full-time position in the human services field assisting children with special needs.</p>
                                <p>With a love for the beach and a craving for a warmer climate, Hilary relocated to Florida in 2006 and worked as an Aquatics Director at a YMCA for over eight years where she developed a year round competitive swim team, administered a progressive swim lesson program and conducted water fitness classes at two aquatics facilities. In May 2015, Hilary took her passion for teaching aquatics programs and established The Swim School, offering private, semi-private and group swim lessons in Manatee County for adults and children 12 months of age and older. She is excited to have the opportunity to develop the North River Rapids Swim Team and is looking forward to the 2018 inaugural season.</p>
                                <a title="Contact Hilary Koppenhaver" class="uk-button uk-button-default" href="tel:+19417731424"><span uk-icon="icon: receiver;" class="uk-margin-small-right"></span> (941) 773-1424</a>
                            </div>
                        </li>
                        {{--<li class="el-item">--}}
                            {{--<img src="">--}}
                            {{--<h3 class="el-title uk-margin uk-heading-bullet">Matt Polk</h3>--}}
                            {{--<div class="el-content uk-margin">--}}
                                {{--<p>Matt grew up Florida and has been swimming competitively for many years with various teams, including the Sarasota YMCA Sharks and Lakewood Ranch High School. He has instructed swim lessons for over 10 years and has worked with all levels of ability, from first time swimmers to Olympic Trials qualifiers. Matt has previously coached for year round competitive swim teams and earned a level 2 USA Swimming coaching certification. He was also the Head Swimming and Diving Coach for Lakewood Ranch High School for several seasons, where the team won numerous County, District, and Regional Championships, and produced individual State Champions.</p>--}}
                                {{--<p>Matt recently graduated Summa Cum Laude from the University of South Florida with a Bachelor of Science in Applied Business. He looks forward to utilizing his extensive swimming background to assist in the coaching and development of swimmers for the North River Swim Team.</p>--}}
                                {{--<a title="Contact Matt Polk" class="uk-button uk-button-default" href="tel:+19414487971"><span uk-icon="icon: receiver;" class="uk-margin-small-right"></span> (941) 448-7971</a>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        {{--<li class="el-item">--}}
                            {{--<img src="">--}}
                            {{--<h3 class="el-title uk-margin uk-heading-bullet">Isabella Ortiz</h3>--}}
                            {{--<div class="el-content uk-margin">--}}
                                {{--<p>Isabella swam competitively for the Lakewood Ranch YMCA Wave Runners for 4 years and the Lakewood Ranch Swim Association for one year. While participating on the swim team, Isabella also volunteered with swim meets and teaching swim lessons. Isabella continued her swimming career through her 4 years of high school making varsity every year with the Lakewood Ranch HS Mustangs.</p>--}}
                                {{--<p>Isabella graduated in May of 2017 from Lakewood Ranch High School and is actively continuing her education at the State College of Florida pursing a degree in Pediatric Nursing. She can’t wait to put her experiences as a swimmer into practice and share her love for the sport of swimming to help teach proper technique and instill confidence in the swimmers of the North River Swim Team.</p>--}}
                                {{--<a title="Contact Isabella Ortiz" class="uk-button uk-button-default" href="tel:+19417737934"><span uk-icon="icon: receiver;" class="uk-margin-small-right"></span> (941) 773-7934</a>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        {{--<li class="el-item">--}}
                            {{--<img src="">--}}
                            {{--<h3 class="el-title uk-margin uk-heading-bullet">Zach Maibach</h3>--}}
                            {{--<div class="el-content uk-margin">--}}
                                {{--<p>Zach grew up in New Jersey, where he graduated from Jackson Memorial High school in 2017. Zach played four years of Soccer, Lacrosse and was on the swim team. He was a varsity swimmer for 3 years specializing in the butterfly, and competed in Counties and Regionals. Zach is currently a student at SCF majoring in Biotechnology Science. He has been a lifeguard for over 3 years and currently works for the Manatee YMCA. Zach became a certified scuba diver in 2013 with dives all over Florida and the Caribbean.</p>--}}
                                {{--<p>Zach is happy to have the opportunity to coach for the North River Swim Team and looks forward to assisting young swimmers with their technique as well as an enthusiasm for swimming.</p>--}}
                                {{--<a title="Contact Zach Maibach" class="uk-button uk-button-default" href="tel:+17326143104"><span uk-icon="icon: receiver;" class="uk-margin-small-right"></span> (732) 614-3104</a>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                    </ul>
                </div>
            </div>

            <div class="uk-width-1-1@m uk-margin-top">
                <h2 class="uk-heading-line"><span>Location</span></h2>
                <div class="uk-child-width-1-1@m uk-grid-small uk-grid-match" uk-grid>
                    <div class="uk-card uk-card-default uk-card-body">
                        <iframe height="300" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=place_id:ChIJf7zB1tYkw4gRegJOom9JbYs&key=AIzaSyAdLooRUbxGjnlY2k8HDa_zkXYQB4U7s9w&zoom=12" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

