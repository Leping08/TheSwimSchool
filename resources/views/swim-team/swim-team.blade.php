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
                <div class="uk-width-2-3@m uk-first-column">
                    <div class="uk-dropcap">
                        <p>Bring your suit, goggles & towel and come join our team! The North River Swim Team practices at the River Wilderness Country Club and competes in a seasonal, developmental swim league that runs May 1st - August 31st. Tryouts are held every Tuesday at 6:30PM. There is no fee to tryout for the swim team.</p>
                        {{--<p>Bring your suit, goggles & towel and come join our team! The North River Swim Team is holding tryouts at the River Wilderness Country Club. Registration for pre-season tryouts opens April 1st, 2018.</p>--}}
                    </div>
                    {{--<div>--}}
                        {{--<h3 class="uk-heading-line"><span>2018 Pre-Season Tryout Dates</span></h3>--}}
                        {{--<ul class="uk-list uk-list-bullet">--}}
                            {{--<li>Wed. 4/18 6:30PM</li>--}}
                            {{--<li>Thurs. 4/19 6:30PM</li>--}}
                            {{--<li>Sat. 4/21 10:00AM</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    {{--<div>--}}
                        {{--<p><strong>There is no fee to tryout for the swim team.</strong></p>--}}
                    {{--</div>--}}
                    {{--<div>--}}
                        {{--<p>The North River Swim Team practices at the <a title="Parrish swim team" target="_blank" href="http://www.riverwildernesscc.com/">River Wilderness Country Club</a> and competes in the Suncoast Swim League, a seasonal developmental league that runs May 1st - August 31st.</p>--}}
                    {{--</div>--}}
                    <div>
                        <!-- TODO: Add tryout that lasts all season -->
                        {{--<a class="uk-button uk-button-primary" href="/swim-team/tryouts">Sign Up for Tryouts</a>--}}
                        {{--<a class="uk-button uk-button-default" disabled>Registration Coming Soon</a>--}}
                    </div>
                </div>
                <div class="uk-width-1-3@m">
                    <div class="uk-margin">
                        <img src="/img/private-lessons.jpg" class="el-image" alt="Bradenton Learn to Swim">
                    </div>
                </div>
            </div>

            <div class="uk-width-1-1@m uk-margin-top">
                <h2 class="uk-heading-line"><span>Groups & Practice Schedules</span></h2>
                <p>Swim team tryout will determine group placement. Swim meet and special events schedule will be posted in May.</p>
                <ul class="uk-list uk-list-bullet">
                    <li><b>Ripple:</b> Tues/Thurs 6PM-6:30PM</li>
                    <li><b>Splash:</b> Mon/Wed/Fri 5PM-5:45PM</li>
                    <li><b>Waves:</b> Mon/Wed/Fri 5:45PM-6:45PM, Sat 9:30AM-10:30AM</li>
                    <li><b>Rapids:</b> Mon/Tues/Wed/Thurs 6:30PM-7:45PM, Sat 8AM-9:30AM</li>
                </ul>
            </div>

            <div class="uk-width-1-1@m uk-margin-top">
                <h2 class="uk-heading-line"><span>Season Pricing</span></h2>
                <p>No Registration Fees! 10% Discount for River Wilderness Country Club Members (Must provide ID number for verification). 10% Multiple Child Discount. Each child will receive one free team swim cap prior to the first swim meet.</p>
                <ul class="uk-list uk-list-bullet">
                    <li><b>Ripple:</b> $200</li>
                    <li><b>Splash:</b> $220</li>
                    <li><b>Waves:</b> $280</li>
                    <li><b>Rapids:</b> $340</li>
                </ul>
            </div>

            <div class="uk-width-1-1@m uk-margin-top">
                <h2 class="uk-heading-line"><span>Coaches</span></h2>
                <div class="uk-margin">
                    <ul uk-tab="connect: #js-350;animation: uk-animation-fade" class="uk-margin el-nav uk-tab">
                        <li aria-expanded="true" class="uk-active">
                            <a href="#">Hilary Koppenhaver</a>
                        </li>
                        <li aria-expanded="false">
                            <a href="#">Matt Polk</a>
                        </li>
                        <li aria-expanded="false">
                            <a href="#">Isabella Ortiz</a>
                        </li>
                        <li aria-expanded="false">
                            <a href="#">Zach Maibach</a>
                        </li>
                        <li aria-expanded="false">
                            <a href="#">Courtney Chapin</a>
                        </li>
                    </ul>

                    <ul id="js-350" class="uk-switcher" uk-height-match="row: false">
                        <li class="el-item">
                            <img src="">
                            <h3 class="el-title uk-margin uk-heading-bullet">Hilary Koppenhaver</h3>
                            <div class="el-content uk-margin">
                                <p>Hilary is originally from Pennsylvania and started swimming at the age of five. She continued competitively through college in Ohio where she earned a B.A. in Psychology. After receiving her degree in 2003, she returned to PA and worked part-time as a lifeguard, swim lesson instructor, and swim team coach in addition to having a full-time position in the human services field assisting children with special needs.</p>
                                <p>With a love for the beach and a craving for a warmer climate, Hilary relocated to Florida in 2006 and worked as an Aquatics Director at a YMCA for over eight years where she developed a year round competitive swim team, administered a progressive swim lesson program and conducted water fitness classes at two aquatics facilities. In May 2015, Hilary took her passion for teaching aquatics programs and established The Swim School, offering private, semi-private and group swim lessons in Manatee County for adults and children 12 months of age and older. She is excited to have the opportunity to develop the North River Rapids Swim Team and is looking forward to the 2018 inaugural season.</p>
                                <a class="uk-button uk-button-default" href="tel:+19417731424"><span uk-icon="icon: receiver;" class="uk-margin-small-right"></span> (941) 773-1424</a>
                            </div>
                        </li>
                        <li class="el-item">
                            <img src="">
                            <h3 class="el-title uk-margin uk-heading-bullet">Matt Polk</h3>
                            <div class="el-content uk-margin">
                                <p>Matt grew up Florida and has been swimming competitively for many years with various teams, including the Sarasota YMCA Sharks and Lakewood Ranch High School. He has instructed swim lessons for over 10 years and has worked with all levels of ability, from first time swimmers to Olympic Trials qualifiers. Matt has previously coached for year round competitive swim teams and earned a level 2 USA Swimming coaching certification. He was also the Head Swimming and Diving Coach for Lakewood Ranch High School for several seasons, where the team won numerous County, District, and Regional Championships, and produced individual State Champions.</p>
                                <p>Matt recently graduated Summa Cum Laude from the University of South Florida with a Bachelor of Science in Applied Business. He looks forward to utilizing his extensive swimming background to assist in the coaching and development of swimmers for the North River Swim Team.</p>
                                <a class="uk-button uk-button-default" href="tel:+19414487971"><span uk-icon="icon: receiver;" class="uk-margin-small-right"></span> (941) 448-7971</a>
                            </div>
                        </li>
                        <li class="el-item">
                            <img src="">
                            <h3 class="el-title uk-margin uk-heading-bullet">Isabella Ortiz</h3>
                            <div class="el-content uk-margin">
                                <p>Isabella swam competitively for the Lakewood Ranch YMCA Wave Runners for 4 years and the Lakewood Ranch Swim Association for one year. While participating on the swim team, Isabella also volunteered with swim meets and teaching swim lessons. Isabella continued her swimming career through her 4 years of high school making varsity every year with the Lakewood Ranch HS Mustangs.</p>
                                <p>Isabella graduated in May of 2017 from Lakewood Ranch High School and is actively continuing her education at the State College of Florida pursing a degree in Pediatric Nursing. She can’t wait to put her experiences as a swimmer into practice and share her love for the sport of swimming to help teach proper technique and instill confidence in the swimmers of the North River Swim Team.</p>
                                <a class="uk-button uk-button-default" href="tel:+19417737934"><span uk-icon="icon: receiver;" class="uk-margin-small-right"></span> (941) 773-7934</a>
                            </div>
                        </li>
                        <li class="el-item">
                            <img src="">
                            <h3 class="el-title uk-margin uk-heading-bullet">Zach Maibach</h3>
                            <div class="el-content uk-margin">
                                <p>Zach grew up in New Jersey, where he graduated from Jackson Memorial High school in 2017. Zach played four years of Soccer, Lacrosse and was on the swim team. He was a varsity swimmer for 3 years specializing in the butterfly, and competed in Counties and Regionals. Zach is currently a student at SCF majoring in Biotechnology Science. He has been a lifeguard for over 3 years and currently works for the Manatee YMCA. Zach became a certified scuba diver in 2013 with dives all over Florida and the Caribbean.</p>
                                <p>Zach is happy to have the opportunity to coach for the North River Swim Team and looks forward to assisting young swimmers with their technique as well as an enthusiasm for swimming.</p>
                                <a class="uk-button uk-button-default" href="tel:+17326143104"><span uk-icon="icon: receiver;" class="uk-margin-small-right"></span> (732) 614-3104</a>
                            </div>
                        </li>
                        <li class="el-item">
                            <img src="">
                            <h3 class="el-title uk-margin uk-heading-bullet">Courtney Chapin</h3>
                            <div class="el-content uk-margin">
                                <p>Courtney has grown up in Florida swimming for nearly 15 years with the Venice Hurricanes and Lakewood Ranch High School where she earned several individual and team titles as captain placing top 3 at States in the backstroke events. She has coached summer league swim teams for three years and summer lessons for two. Courtney has just finished up her Freshmen year swimming for FGCU and intends to major in Health Science and earn her Olympic trial cuts for the 2020 Olympic Games. She is excited to use her knowledge and years of experience swimming to help grow and develop the swimmers of the North River Swim Team.</p>
                                <a class="uk-button uk-button-default" href="tel:+19417794569"><span uk-icon="icon: receiver;" class="uk-margin-small-right"></span> (941) 779-4569</a>
                            </div>
                        </li>
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

