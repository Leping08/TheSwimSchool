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

